@extends('layouts.main')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/usuario.css') }}">
@endsection
@section('title', 'Inicio Usuario')

@section('content')
<div class="container">
    <h1 class="mb-4">Productos en Oferta</h1>

    {{-- Filtro por categoría --}}
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="categoria">Filtrar por Categoría:</label>
            <select id="categoria" class="form-control">
                <option value="">Todas</option>
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id_categoria }}" {{ (isset($categoriaId) && $categoriaId == $categoria->id_categoria) ? 'selected' : '' }}>{{ $categoria->nuevo_nombre ?? $categoria->nombre_categoria }}</option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- Listado de productos --}}
    <div class="row" id="productos-lista">
        @if($productos->isEmpty())
            <div class="col-12 text-center my-4">
                <div class="alert alert-info">No hay productos para esta categoría.</div>
            </div>
        @else
            @foreach($productos as $producto)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        @if($producto->imagen)
                            <img src="{{ asset('storage/' . $producto->imagen) }}" class="card-img-top" alt="{{ $producto->nombres }}">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $producto->nombres }}</h5>
                            <p class="card-text">Categoría: {{ $producto->categoria->nuevo_nombre ?? $producto->categoria->nombre_categoria }}</p>
                            <p class="card-text">Stock: {{ $producto->cantidad }}</p>
                            
                            @if($producto->descuento > 0)
                                <p class="card-text text-danger">Descuento: {{ $producto->descuento }}%</p>
                                <p class="card-text">
                                    <del>${{ number_format($producto->valor, 0) }}</del>
                                    <strong>${{ number_format($producto->valor * (1 - $producto->descuento / 100), 0) }}</strong>
                                </p>
                            @else
                                <p class="card-text">Precio: ${{ number_format($producto->valor, 0) }}</p>
                            @endif

                            <a href="{{ route('usuario.detalle_producto', $producto->id) }}" class="btn btn-primary">Ver Detalle</a>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('categoria').addEventListener('change', function () {
        const categoria = this.value;
        if (categoria) {
            window.location.href = "{{ url('/home') }}?categoria=" + categoria;
        } else {
            window.location.href = "{{ url('/home') }}";
        }
    });
</script>
<script src="{{ asset('js/usuario.js') }}"></script>
@endsection
