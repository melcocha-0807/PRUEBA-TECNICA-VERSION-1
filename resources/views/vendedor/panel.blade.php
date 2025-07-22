@extends('layouts.main')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/vendedor.css') }}">
@endsection
@section('content')
<div class="container">
    <h1 class="mb-4">Panel de Ventas</h1>
    <div class="mb-4">
        <h3>Registrar Nueva Venta</h3>
        <form method="POST" action="{{ route('vendedor.registrarVenta') }}">
            @csrf
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="producto_id">Producto</label>
                    <select class="form-control" id="producto_id" name="productos[0][producto_id]" required>
                        <option value="">Seleccione...</option>
                        @foreach($productos as $producto)
                            <option value="{{ $producto->id }}">{{ $producto->nombres }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <label for="cantidad_venta">Cantidad</label>
                    <input type="number" class="form-control" id="cantidad_venta" name="productos[0][cantidad_venta]" min="1" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="producto_id_2">Producto 2</label>
                    <select class="form-control" id="producto_id_2" name="productos[1][producto_id]" optional>
                        <option value="">Seleccione...</option>
                        @foreach($productos as $producto)
                            <option value="{{ $producto->id }}">{{ $producto->nombres }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <label for="cantidad_venta_2">Cantidad 2</label>
                    <input type="number" class="form-control" id="cantidad_venta_2" name="productos[1][cantidad_venta]" min="1" optional>
                </div>
                    <div class="form-group col-md-4">
                    <label for="usuario_id">usuario</label>
                    <select class="form-control" id="usuario_id" name="usuario_id" required>
                        <option value="">Seleccione...</option>
                        @foreach($usuarios as $usuario)
                            <option value="{{ $usuario->id }}">{{ $usuario->nombres }} {{ $usuario->apellidos }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-2 align-self-end">
                    <button type="submit" class="btn btn-success">Registrar Venta</button>
                </div>
            </div>
        </form>
    </div>
    <hr>
    <h3>Historial de Ventas</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Productos</th>
                <th>Cantidad Total</th>
                <th>Subtotal</th>
                <th>Descuento</th>
                <th>Total</th>
                <th>Usuario</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ventas as $venta)
                <tr>
                    <td>{{ $venta->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $venta->producto->nombres }}</td>
                    <td>{{ $venta->cantidad_venta }}</td>
                    <td>${{ number_format($venta->subtotal, 0) }}</td>
                    <td>{{ $venta->descuento }}%</td>
                    <td>${{ number_format($venta->total, 0) }}</td>
                    <td>{{ $venta->usuario->nombres }} {{ $venta->usuario->apellidos }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection