<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;

class AuxiliarController extends Controller
{
    // Mostrar listado y formulario de productos
    public function productos()
    {
        $productos = Producto::with('categoria')->get();
        $categorias = Categoria::all();
        return view('auxiliar.productos', compact('productos', 'categorias'));
    }

    // Guardar nuevo producto
    public function storeProducto(Request $request)
    {
        $data = $request->validate([
            'nombres' => 'required|string|max:255',
            'cantidad' => 'required|integer|min:0',
            'valor' => 'required|integer|min:0',
            'id_categoria' => 'required|exists:categorias,id_categoria',
            'imagen' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

        Producto::create($data);
        return redirect()->back()->with('success', 'Producto creado correctamente');
    }

    // Mostrar formulario de edición
    public function editProducto($id)
    {
        $producto = Producto::findOrFail($id);
        $categorias = Categoria::all();
        return view('auxiliar.editar_producto', compact('producto', 'categorias'));
    }

    // Actualizar producto
    public function updateProducto(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);

        $data = $request->validate([
            'nombres' => 'required|string|max:255',
            'cantidad' => 'required|integer|min:0',
            'valor' => 'required|integer|min:0',
            'id_categoria' => 'required|exists:categorias,id_categoria',
            'imagen' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

        $producto->update($data);
        return redirect()->route('auxiliar.productos')->with('success', 'Producto actualizado correctamente');
    }

    // Eliminar producto
    public function destroyProducto($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->delete();
        return redirect()->back()->with('success', 'Producto eliminado correctamente');
    }
}
