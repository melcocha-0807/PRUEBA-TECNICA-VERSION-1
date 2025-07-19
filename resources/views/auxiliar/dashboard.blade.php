@extends('layouts.main')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/auxiliar.css') }}">
@endsection
@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Dashboard del Auxiliar de Bodega</h2>
    <div class="row">
        <div class="col-md-6">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title">Administrar Productos</h5>
                    <p class="card-text">Agrega, edita o elimina productos del inventario.</p>
                    <a href="{{ route('auxiliar.productos') }}" class="btn btn-primary">Ir a Productos</a>
                </div>
            </div>
        </div>
        {{-- Puedes agregar más tarjetas si necesitas más secciones --}}
        <div class="col-md-6">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title">Estadísticas (Futuro)</h5>
                    <p class="card-text">Aquí se podrán ver reportes e indicadores.</p>
                    <button class="btn btn-secondary" disabled>Próximamente</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/auxiliar.js') }}"></script>
@endsection
