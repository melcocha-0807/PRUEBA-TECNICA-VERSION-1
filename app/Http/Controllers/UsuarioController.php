<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
<<<<<<< HEAD
=======
use Illuminate\Support\Facades\Hash;
>>>>>>> origin/master
use App\Models\Producto;
use App\Models\Categoria;

class UsuarioController extends Controller
{
    // Vista principal del usuario con productos y categorías
    public function home()
    {
        $productos = Producto::with('categoria')->get();
        $categorias = Categoria::all();
        return view('usuario.home', compact('productos', 'categorias'));
    }

    // Mostrar vista de perfil
    public function perfil()
    {
        $usuario = Auth::user();
        return view('usuario.perfil', compact('usuario'));
    }

    // Actualizar perfil
    public function updatePerfil(Request $request)
    {
        $usuario = Auth::user();

        $data = $request->validate([
            'identificacion' => 'required|string|max:45|unique:usuarios,identificacion,' . $usuario->id,
            'nombres' => 'required|string|max:200',
            'apellidos' => 'required|string|max:200',
            'email' => 'required|email|max:150|unique:usuarios,email,' . $usuario->id,
            'telefono' => 'nullable|string|max:45',
            'password' => 'nullable|string|min:8|confirmed',
        ], [
            'identificacion.unique' => 'Esta identificación ya está en uso.',
            'email.unique' => 'Este email ya está en uso.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'La confirmación de contraseña no coincide.',
        ]);

        // Solo actualizar password si se proporcionó
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        try {
            $usuario->update($data);
            return redirect()->back()->with('success', 'Perfil actualizado correctamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al actualizar el perfil');
        }
    }

    // Detalle de producto
    public function detalleProducto($id)
    {
        $producto = Producto::with('categoria')->findOrFail($id);
        return view('usuario.detalle_producto', compact('producto'));
    }

    // Mostrar el carrito desde sesión
    public function carrito()
    {
        $carrito = session('carrito', []);
        $total = 0;
        
        foreach ($carrito as $item) {
            $subtotal = $item->producto->valor * $item->cantidad;
            $descuento = $item->producto->descuento ?? 0;
            $total += $subtotal * (1 - $descuento / 100);
        }
        
        return view('usuario.carrito', compact('carrito', 'total'));
    }

    // Agregar producto al carrito
    public function agregarAlCarrito(Request $request, $id)
    {
<<<<<<< HEAD
        $producto = Producto::findOrFail($id);
=======
        $producto = Producto::with('categoria')->findOrFail($id);
>>>>>>> origin/master
        $cantidad = (int) $request->input('cantidad', 1);

        // Validar cantidad solicitada
        if ($cantidad <= 0) {
            return redirect()->back()->with('error', 'La cantidad debe ser mayor a 0');
        }

        if ($cantidad > $producto->cantidad) {
            return redirect()->back()->with('error', 'No hay suficiente stock disponible');
        }

        $carrito = session('carrito', []);

        // Verificar si ya está en el carrito
        $existe = false;
        foreach ($carrito as &$item) {
            if ($item->producto->id === $producto->id) {
                $nuevaCantidad = $item->cantidad + $cantidad;
                
                // Verificar stock total
                if ($nuevaCantidad > $producto->cantidad) {
                    return redirect()->back()->with('error', 'No hay suficiente stock para agregar esa cantidad');
                }
                
                $item->cantidad = $nuevaCantidad;
                $existe = true;
                break;
            }
        }

        if (!$existe) {
            $carrito[] = (object)[
                'id' => uniqid(),
                'producto' => $producto,
                'cantidad' => $cantidad,
            ];
        }

        session(['carrito' => $carrito]);
        return redirect()->route('usuario.carrito')->with('success', 'Producto agregado al carrito');
    }

    // Actualizar cantidad en carrito
    public function actualizarCarrito(Request $request, $itemId)
    {
        $nuevaCantidad = (int) $request->input('cantidad', 1);
        
        if ($nuevaCantidad <= 0) {
            return $this->eliminarDelCarrito($itemId);
        }

        $carrito = session('carrito', []);

        foreach ($carrito as &$item) {
            if ($item->id === $itemId) {
                // Verificar stock disponible
                if ($nuevaCantidad > $item->producto->cantidad) {
                    return redirect()->back()->with('error', 'No hay suficiente stock disponible');
                }
                
                $item->cantidad = $nuevaCantidad;
                break;
            }
        }

        session(['carrito' => $carrito]);
        return redirect()->route('usuario.carrito')->with('success', 'Cantidad actualizada');
    }

    // Eliminar item del carrito
    public function eliminarDelCarrito($itemId)
    {
        $carrito = session('carrito', []);

        $carrito = array_filter($carrito, function ($item) use ($itemId) {
            return $item->id !== $itemId;
        });

        session(['carrito' => array_values($carrito)]); // Reindexar
        return redirect()->route('usuario.carrito')->with('success', 'Producto eliminado del carrito');
    }

    // Vaciar carrito completo
    public function vaciarCarrito()
    {
        session()->forget('carrito');
        return redirect()->route('usuario.carrito')->with('success', 'Carrito vaciado');
    }

    // Simulación de pedido
    public function realizarPedido()
    {
        $carrito = session('carrito', []);
        
        if (empty($carrito)) {
            return redirect()->route('usuario.carrito')->with('error', 'El carrito está vacío');
        }

        // Aquí podrías agregar lógica adicional como:
        // - Verificar stock nuevamente
        // - Crear registro de pedido
        // - Reducir stock de productos
        // - Enviar email de confirmación

        session()->forget('carrito');
        return redirect()->route('usuario.home')->with('success', 'Pedido realizado con éxito');
    }
}