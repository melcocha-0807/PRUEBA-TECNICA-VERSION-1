<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Producto;
use App\Models\Usuario;
use App\Models\HistorialVenta;

class VendedorController extends Controller
{
    // Panel de ventas e historial
    public function panel()
    {
        $productos = Producto::all();
        $usuarios = Usuario::where('rol', 'usuario')->get();
        $ventas = HistorialVenta::with(['producto', 'usuario'])
            ->where('vendedor_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        $usuario = Auth::user();

        // Renderiza la vista panel para la ruta vendedor.dashboard
        return view('vendedor.panel', compact('productos', 'usuarios', 'ventas'));
    }

    // Registrar nueva venta
    public function registrarVenta(Request $request)
    {
        $data = $request->validate([
            'productos' => 'required|array|min:2', // Asegúrate de que se envían al menos dos productos
            'productos.*.producto_id' => 'required|exists:productos,id',
            'productos.*.cantidad_venta' => 'required|integer|min:1',
            'usuario_id' => 'required|exists:usuarios,id',
        ]);

        $totalSubtotal = 0;
        $productosDiferentes = [];

        foreach ($data['productos'] as $productoData) {
            $producto = Producto::findOrFail($productoData['producto_id']);
            $productosDiferentes[$producto->id] = true;

            // Validar stock disponible
            if ($producto->cantidad < $productoData['cantidad_venta']) {
                return redirect()->back()->with('error', 'No hay suficiente stock disponible para esta venta.');
            }

            $subtotal = $producto->valor * $productoData['cantidad_venta'];
            $totalSubtotal += $subtotal;
        }

        // Aplicar descuento si hay al menos dos productos diferentes
        $descuento = count($productosDiferentes) >= 2 ? 20 : 0;
        $totalDescuento = $totalSubtotal * ($descuento / 100);
        $totalFinal = $totalSubtotal - $totalDescuento;

        // Registrar venta en historial
        HistorialVenta::create([
            'producto_id'    => $producto->id,
            'vendedor_id'    => Auth::id(),
            'usuario_id'   => $data['usuario_id'],
            'cantidad_venta' => array_sum(array_column($data['productos'], 'cantidad_venta')),
            'subtotal'       => $totalSubtotal,
            'descuento'      => $descuento,
            'total'          => $totalFinal,
        ]);

        // Actualizar stock
        foreach ($data['productos'] as $productoData) {
            $producto = Producto::findOrFail($productoData['producto_id']);
            $producto->cantidad -= $productoData['cantidad_venta'];
            $producto->save();
        }

        return redirect()->back()->with('success', 'Venta registrada correctamente con descuento.');
    }
}