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
                    <select class="form-control" id="producto_id" name="producto_id" required>
                        <option value="">Seleccione...</option>
                        @foreach($productos as $producto)
                            <option value="{{ $producto->id }}">{{ $producto->nombres }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <label for="cantidad_venta">Cantidad</label>
                    <input type="number" class="form-control" id="cantidad_venta" name="cantidad_venta" min="1" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="comprador_id">Comprador</label>
                    <select class="form-control" id="comprador_id" name="comprador_id" required>
                        <option value="">Seleccione...</option>
                        @foreach($compradores as $comprador)
                            <option value="{{ $comprador->id }}">{{ $comprador->nombres }} {{ $comprador->apellidos }}</option>
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
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Subtotal</th>
                <th>Descuento</th>
                <th>Total</th>
                <th>Comprador</th>
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
                    <td>{{ $venta->comprador->nombres }} {{ $venta->comprador->apellidos }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
