<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Producto;
use App\Models\Usuario;
use App\Models\HistorialVenta;

class VendedorController extends Controller
{
    // Panel de ventas e historial
    public function panel()
    {
        $productos = Producto::with('categoria')->where('cantidad', '>', 0)->get();
        $compradores = Usuario::where('rol', 'usuario')->get();
        $ventas = HistorialVenta::with(['producto', 'comprador'])
            ->where('vendedor_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('vendedor.panel', compact('productos', 'compradores', 'ventas'));
    }

    // Registrar nueva venta
    public function registrarVenta(Request $request)
    {
        $data = $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad_venta' => 'required|integer|min:1',
            'comprador_id' => 'required|exists:usuarios,id',
        ], [
            'producto_id.required' => 'Debe seleccionar un producto.',
            'producto_id.exists' => 'El producto seleccionado no existe.',
            'cantidad_venta.required' => 'La cantidad es obligatoria.',
            'cantidad_venta.min' => 'La cantidad debe ser mayor a 0.',
            'comprador_id.required' => 'Debe seleccionar un comprador.',
            'comprador_id.exists' => 'El comprador seleccionado no existe.',
        ]);

        try {
            DB::transaction(function () use ($data) {
                $producto = Producto::lockForUpdate()->findOrFail($data['producto_id']);

                // Validar stock disponible
                if ($producto->cantidad < $data['cantidad_venta']) {
                    throw new \Exception('No hay suficiente stock disponible para esta venta. Stock actual: ' . $producto->cantidad);
                }

                // Validar que el comprador sea realmente un usuario
                $comprador = Usuario::where('id', $data['comprador_id'])
                    ->where('rol', 'usuario')
                    ->first();
                
                if (!$comprador) {
                    throw new \Exception('El comprador seleccionado no es válido.');
                }

                // Calcular montos
                $subtotal = $producto->valor * $data['cantidad_venta'];
                $descuento = $producto->descuento ?? 0;
                $total = $subtotal * (1 - $descuento / 100);

                // Registrar venta en historial
                HistorialVenta::create([
                    'producto_id' => $producto->id,
                    'vendedor_id' => Auth::id(),
                    'comprador_id' => $data['comprador_id'],
                    'cantidad_venta' => $data['cantidad_venta'],
                    'subtotal' => $subtotal,
                    'descuento' => $descuento,
                    'total' => $total,
                ]);

                // Actualizar stock
                $producto->cantidad -= $data['cantidad_venta'];
                $producto->save();
            });

            return redirect()->back()->with('success', 'Venta registrada correctamente.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al registrar la venta: ' . $e->getMessage());
        }
    }

    // Ver detalle de una venta específica
    public function detalleVenta($id)
    {
        $venta = HistorialVenta::with(['producto', 'comprador', 'vendedor'])
            ->where('id', $id)
            ->where('vendedor_id', Auth::id())
            ->firstOrFail();

        return view('vendedor.detalle_venta', compact('venta'));
    }

    // Reporte de ventas por fecha
    public function reporteVentas(Request $request)
    {
        $fechaInicio = $request->input('fecha_inicio', now()->startOfMonth()->toDateString());
        $fechaFin = $request->input('fecha_fin', now()->toDateString());

        $ventas = HistorialVenta::with(['producto', 'comprador'])
            ->where('vendedor_id', Auth::id())
            ->whereBetween('created_at', [$fechaInicio, $fechaFin])
            ->orderBy('created_at', 'desc')
            ->get();

        $totalVentas = $ventas->sum('total');
        $cantidadVentas = $ventas->count();

        return view('vendedor.reporte_ventas', compact('ventas', 'totalVentas', 'cantidadVentas', 'fechaInicio', 'fechaFin'));
    }

    // Productos más vendidos
    public function productosMasVendidos()
    {
        $productos = HistorialVenta::with('producto')
            ->where('vendedor_id', Auth::id())
            ->select('producto_id', DB::raw('SUM(cantidad_venta) as total_vendido'), DB::raw('SUM(total) as total_ingresos'))
            ->groupBy('producto_id')
            ->orderBy('total_vendido', 'desc')
            ->limit(10)
            ->get();

        return view('vendedor.productos_mas_vendidos', compact('productos'));
    }

    // Actualizar venta (AJAX)
    public function actualizarVenta(Request $request, $id)
    {
        try {
            $venta = HistorialVenta::where('id', $id)
                ->where('vendedor_id', Auth::id())
                ->firstOrFail();

            $data = $request->validate([
                'cantidad_venta' => 'required|integer|min:1',
                'comprador_id' => 'required|exists:usuarios,id',
            ]);

            DB::transaction(function () use ($venta, $data) {
                $producto = Producto::lockForUpdate()->findOrFail($venta->producto_id);

                // Calcular diferencia de stock
                $diferenciaCantidad = $data['cantidad_venta'] - $venta->cantidad_venta;
                
                // Verificar stock disponible si aumenta la cantidad
                if ($diferenciaCantidad > 0 && $producto->cantidad < $diferenciaCantidad) {
                    throw new \Exception('No hay suficiente stock disponible. Stock actual: ' . $producto->cantidad);
                }

                // Validar comprador
                $comprador = Usuario::where('id', $data['comprador_id'])
                    ->where('rol', 'usuario')
                    ->first();
                
                if (!$comprador) {
                    throw new \Exception('El comprador seleccionado no es válido.');
                }

                // Recalcular montos
                $subtotal = $producto->valor * $data['cantidad_venta'];
                $descuento = $producto->descuento ?? 0;
                $total = $subtotal * (1 - $descuento / 100);

                // Actualizar venta
                $venta->update([
                    'cantidad_venta' => $data['cantidad_venta'],
                    'comprador_id' => $data['comprador_id'],
                    'subtotal' => $subtotal,
                    'descuento' => $descuento,
                    'total' => $total,
                ]);

                // Ajustar stock del producto
                $producto->cantidad -= $diferenciaCantidad;
                $producto->save();
            });

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Venta actualizada correctamente',
                    'venta' => $venta->load(['producto', 'comprador'])
                ]);
            }

            return redirect()->back()->with('success', 'Venta actualizada correctamente');

        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al actualizar la venta: ' . $e->getMessage()
                ], 422);
            }

            return redirect()->back()->with('error', 'Error al actualizar la venta: ' . $e->getMessage());
        }
    }

    // Eliminar venta (AJAX)
    public function eliminarVenta(Request $request, $id)
    {
        try {
            $venta = HistorialVenta::where('id', $id)
                ->where('vendedor_id', Auth::id())
                ->firstOrFail();

            DB::transaction(function () use ($venta) {
                $producto = Producto::lockForUpdate()->findOrFail($venta->producto_id);

                // Devolver stock al producto
                $producto->cantidad += $venta->cantidad_venta;
                $producto->save();

                // Eliminar venta
                $venta->delete();
            });

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Venta eliminada correctamente'
                ]);
            }

            return redirect()->back()->with('success', 'Venta eliminada correctamente');

        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al eliminar la venta: ' . $e->getMessage()
                ], 422);
            }

            return redirect()->back()->with('error', 'Error al eliminar la venta: ' . $e->getMessage());
        }
    }

    // Obtener detalles de venta para modal (AJAX)
    public function obtenerVenta($id)
    {
        try {
            $venta = HistorialVenta::with(['producto', 'comprador'])
                ->where('id', $id)
                ->where('vendedor_id', Auth::id())
                ->firstOrFail();

            return response()->json([
                'success' => true,
                'venta' => $venta
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Venta no encontrada'
            ], 404);
        }
    }
}