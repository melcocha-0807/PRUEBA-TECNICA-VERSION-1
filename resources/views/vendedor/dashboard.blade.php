@extends('layouts.main')

@section('title', 'Dashboard Vendedor')

@section('content')
<div class="container mt-4">
    <h1 class="mb-3">Dashboard Vendedor</h1>
    <p>Bienvenido al panel principal del vendedor. Aquí puedes gestionar ventas y ver tu historial.</p>

    <div class="mt-4">
        <a href="{{ route('vendedor.panel') }}" class="btn btn-primary">
            Ir al Panel de Ventas
        </a>
    </div>
</div>

<script src="{{ asset('js/vendedor.js') }}"></script>
@endsection
