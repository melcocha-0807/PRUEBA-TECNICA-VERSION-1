@extends('layouts.main')

@section('content')
<div class="container mt-4" style="max-width: 700px;">
    <h1 class="mb-4 text-center">Registro de Usuario</h1>

    {{-- Mostrar errores de validación --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register.submit') }}">
        @csrf

        <div class="mb-3">
            <label for="identificacion" class="form-label">Identificación</label>
            <input type="text" class="form-control" id="identificacion" name="identificacion" 
                   value="{{ old('identificacion') }}" required maxlength="45">
        </div>

        <div class="mb-3">
            <label for="nombres" class="form-label">Nombres</label>
            <input type="text" class="form-control" id="nombres" name="nombres" 
                   value="{{ old('nombres') }}" required maxlength="200">
        </div>

        <div class="mb-3">
            <label for="apellidos" class="form-label">Apellidos</label>
            <input type="text" class="form-control" id="apellidos" name="apellidos" 
                   value="{{ old('apellidos') }}" required maxlength="200">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Correo electrónico</label>
            <input type="email" class="form-control" id="email" name="email" 
                   value="{{ old('email') }}" required maxlength="150">
        </div>

        <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="text" class="form-control" id="telefono" name="telefono" 
                   value="{{ old('telefono') }}" maxlength="45">
        </div>

        <div class="mb-3">
            <label for="rol" class="form-label">Rol</label>
            <select class="form-control" id="rol" name="rol" required>
                <option value="">Selecciona un rol</option>
                <option value="usuario" {{ old('rol') == 'usuario' ? 'selected' : '' }}>Usuario</option>
                <option value="vendedor" {{ old('rol') == 'vendedor' ? 'selected' : '' }}>Vendedor</option>
                <option value="auxiliar de bodega" {{ old('rol') == 'auxiliar de bodega' ? 'selected' : '' }}>Auxiliar de Bodega</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" class="form-control" id="password" name="password" 
                   required minlength="6">
        </div>

        <button type="submit" class="btn btn-primary w-100">Registrarse</button>
    </form>
</div>
@endsection
