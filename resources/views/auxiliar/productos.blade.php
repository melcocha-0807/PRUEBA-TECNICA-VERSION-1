@extends('layouts.main')

@section('content')
<div class="container">
    <h1 class="mb-4">Administración de Productos</h1>

    {{-- Mensajes de éxito/error --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Formulario para nuevo producto --}}
    <div class="mb-4">
        <h3>Crear Nuevo Producto</h3>
        <form method="POST" action="{{ route('auxiliar.productos.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="nombres">Nombre</label>
                    <input type="text" class="form-control" id="nombres" name="nombres" required>
                </div>
                <div class="form-group col-md-2">
                    <label for="cantidad">Cantidad</label>
                    <input type="number" class="form-control" id="cantidad" name="cantidad" min="0" required>
                </div>
                <div class="form-group col-md-2">
                    <label for="valor">Valor</label>
                    <input type="number" class="form-control" id="valor" name="valor" min="0" required>
                </div>
                <div class="form-group col-md-2">
                    <label for="id_categoria">Categoría</label>
                    <select class="form-control" id="id_categoria" name="id_categoria" required>
                        <option value="">Seleccione...</option>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->id_categoria }}">{{ $categoria->nuevo_nombre ?? $categoria->nombre_categoria }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="imagen">Imagen</label>
                    <input type="file" class="form-control-file" id="imagen" name="imagen">
                </div>
                <div class="form-group col-md-6 align-self-end">
                    <button type="submit" class="btn btn-primary">Crear Producto</button>
                </div>
            </div>
        </form>
    </div>

    <hr>

    {{-- Tabla de productos --}}
    <h3>Listado de Productos</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Imagen</th>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Cantidad</th>
                <th>Valor</th>
                                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($productos as $producto)
                <tr>
                    <td>
                        @if($producto->imagen)
                            <div class="imagen-producto-container text-center">
    <img src="{{ asset('storage/' . $producto->imagen) }}" class="imagen-producto" alt="{{ $producto->nombres }}">
</div>
                        @endif
                    </td>
                    <td>{{ $producto->nombres }}</td>
                    <td>
    @if(isset($producto->categoria))
        {{ $producto->categoria->nuevo_nombre ?? $producto->categoria->nombre_categoria }}
    @else
        <span class="text-danger">Sin categoría</span>
    @endif
</td>
                    <td>{{ $producto->cantidad }}</td>
                    <td>${{ number_format($producto->valor, 0) }}</td>
                                        <td>
                        <a href="{{ route('auxiliar.productos.edit', $producto->id) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form method="POST" action="{{ route('auxiliar.productos.destroy', $producto->id) }}" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script src="{{ asset('js/auxiliar.js') }}"></script>
@endsection
