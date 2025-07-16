@extends('layouts.main')

@section('title', 'Bienvenido a POS')

@section('content')
<div class="container text-center py-5">
    <h1 class="display-4 mb-4">Bienvenido a POS</h1>
    <p class="lead mb-5">Sistema de Punto de Venta. Por favor, inicia sesión o regístrate para continuar.</p>

    <div class="d-flex justify-content-center gap-3">
        <a href="{{ route('login') }}" class="btn btn-primary btn-lg">Iniciar Sesión</a>
        <a href="{{ route('register') }}" class="btn btn-outline-secondary btn-lg">Registrarse</a>
    </div>
</div>
@endsection
