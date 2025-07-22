<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Producto;
use App\Models\Categoria;

class UsuarioController extends Controller
{
    // Vista principal del usuario con productos y categorías
    public function home(Request $request)
    {
        $categoriaId = $request->input('categoria');
        $query = Producto::with('categoria');
        if ($categoriaId) {
            $query->where('id_categoria', $categoriaId);
        }
        $productos = $query->get();
        $categorias = Categoria::all();
        return view('usuario.home', compact('productos', 'categorias', 'categoriaId'));
    }

    // Mostrar vista de perfil
    public function perfil()
    {
        $usuario = Auth::user();
        return view('usuario.perfil', compact('usuario'));
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
        $carrito = array_map(function($item) {
            $item->producto = Producto::with('categoria')->find($item->producto->id);
            return $item;
        }, $carrito);
        return view('usuario.carrito', compact('carrito'));
    }

    // Agregar producto al carrito
    public function agregarAlCarrito(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);
        $cantidad = (int) $request->input('cantidad', 1);

        $carrito = session('carrito', []);

        // Si ya está en el carrito, suma la cantidad
        $existe = false;
        foreach ($carrito as &$item) {
            if ($item->producto->id === $producto->id) {
                $item->cantidad += $cantidad;
                $existe = true;
                break;
            }
        }

        if (!$existe) {
            $carrito[] = (object)[
                'id'       => uniqid(),
                'producto' => $producto,
                'cantidad' => $cantidad,
            ];
        }

        session(['carrito' => $carrito]);
        return redirect()->route('usuario.carrito')->with('success', 'Producto agregado al carrito');
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

    // Simulación de pedido
    public function realizarPedido()
    {
        session()->forget('carrito');
        return redirect()->route('usuario.home')->with('success', 'Pedido realizado con éxito');
    }
}
