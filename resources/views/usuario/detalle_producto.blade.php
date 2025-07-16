@extends('layouts.main')

@section('title', 'Detalle del Producto')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            @if($producto->imagen)
                <img src="{{ asset('storage/' . $producto->imagen) }}" class="img-fluid" alt="{{ $producto->nombres }}">
            @endif
        </div>

        <div class="col-md-6">
            <h2>{{ $producto->nombres }}</h2>
            <p><strong>Categoría:</strong> {{ $producto->categoria->nombre_categoria }}</p>
            <p><strong>Stock:</strong> {{ $producto->cantidad }}</p>

            @if($producto->descuento > 0)
                <p class="text-danger"><strong>Descuento:</strong> {{ $producto->descuento }}%</p>
                <p>
                    <del>${{ number_format($producto->valor, 0) }}</del>
                    <strong>${{ number_format($producto->valor * (1 - $producto->descuento / 100), 0) }}</strong>
                </p>
            @else
                <p><strong>Precio:</strong> ${{ number_format($producto->valor, 0) }}</p>
            @endif

            {{-- Agregar al carrito --}}
            <form method="POST" action="{{ route('carrito.agregar', $producto->id) }}">
                @csrf
                <div class="form-group">
                    <label for="cantidad">Cantidad</label>
                    <input type="number" class="form-control" id="cantidad" name="cantidad" value="1" min="1" max="{{ $producto->cantidad }}" required>
                </div>
                <button type="submit" class="btn btn-primary mt-2">Agregar al carrito</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/usuario.js') }}"></script>
@endsection
