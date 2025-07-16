@extends('layouts.main')

@section('title', 'Mi Carrito')

@section('content')
<div class="container">
    <h1 class="mb-4">Mi Carrito</h1>

    @if(count($carrito) > 0)
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Categoría</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Descuento</th>
                    <th>Subtotal</th>
                    <th>Eliminar</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach($carrito as $item)
                    @php
                        $precio = $item->producto->valor;
                        $descuento = $item->producto->descuento;
                        $precio_final = $precio * (1 - $descuento / 100);
                        $subtotal = $precio_final * $item->cantidad;
                        $total += $subtotal;
                    @endphp
                    <tr>
                        <td>{{ $item->producto->nombres }}</td>
                        <td>{{ $item->producto->categoria->nombre_categoria }}</td>
                        <td>{{ $item->cantidad }}</td>
                        <td>${{ number_format($precio, 0) }}</td>
                        <td>{{ $descuento }}%</td>
                        <td>${{ number_format($subtotal, 0) }}</td>
                        <td>
                            <form method="POST" action="{{ route('carrito.quitar', $item->id) }}">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="text-end mb-3">
            <h4>Total: ${{ number_format($total, 0) }}</h4>
        </div>

        <form method="POST" action="{{ route('carrito.checkout') }}">
            @csrf
            <button type="submit" class="btn btn-success">Realizar Pedido</button>
        </form>
    @else
        <div class="alert alert-info">No hay productos en el carrito.</div>
    @endif
</div>
@endsection

@section('scripts')
<script src="{{ mix('js/usuario.js') }}"></script>
@endsection
