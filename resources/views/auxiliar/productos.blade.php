@extends('layouts.main')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/auxiliar.css') }}">
@endsection
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

    {{-- Botón para mostrar formulario de nuevo producto --}}
    <div class="mb-4">
        <button id="btn-mostrar-crear" class="btn btn-success mb-2">Crear Nuevo Producto</button>
        <div id="form-crear-producto-container" style="display:none;"></div>
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
                <th>Descuento</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="productos-tbody">
            @foreach($productos as $producto)
                <tr data-producto-id="{{ $producto->id }}">
                    <td>
                        @if($producto->imagen)
                            <img src="{{ asset('storage/' . $producto->imagen) }}" width="60" alt="{{ $producto->nombres }}">
                        @endif
                    </td>
                    <td>{{ $producto->nombres }}</td>
                    <td>{{ $producto->categoria->nombre_categoria }}</td>
                    <td>{{ $producto->cantidad }}</td>
                    <td>${{ number_format($producto->valor, 0) }}</td>
                    <td>{{ $producto->descuento }}%</td>
                    <td>
                        <button class="btn btn-warning btn-sm btn-mostrar-editar">Editar</button>
                        <button class="btn btn-danger btn-sm btn-mostrar-eliminar">Eliminar</button>
                        <div class="form-editar-container mt-2" style="display:none;"></div>
                        <div class="form-eliminar-container mt-2" style="display:none;"></div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script src="{{ asset('js/auxiliar.js') }}"></script>
@endsection
