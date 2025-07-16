@extends('layouts.main')

@section('title', 'Mi Perfil')

@section('content')
<div class="container">
    <h1 class="mb-4">Mi Perfil</h1>

    <form method="POST" action="{{ route('usuario.perfil.update') }}">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label for="identificacion">Identificación</label>
            <input type="text" class="form-control" id="identificacion" name="identificacion"
                value="{{ old('identificacion', $usuario->identificacion) }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="nombres">Nombres</label>
            <input type="text" class="form-control" id="nombres" name="nombres"
                value="{{ old('nombres', $usuario->nombres) }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="apellidos">Apellidos</label>
            <input type="text" class="form-control" id="apellidos" name="apellidos"
                value="{{ old('apellidos', $usuario->apellidos) }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="email">Correo electrónico</label>
            <input type="email" class="form-control" id="email" name="email"
                value="{{ old('email', $usuario->email) }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="telefono">Teléfono</label>
            <input type="text" class="form-control" id="telefono" name="telefono"
                value="{{ old('telefono', $usuario->telefono) }}" required>
        </div>

        <div class="form-group mb-4">
            <label for="password">Contraseña (dejar en blanco si no se desea cambiar)</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>

        <button type="submit" class="btn btn-success">Actualizar Perfil</button>
    </form>
</div>
@endsection

@section('scripts')
<script src="{{ mix('js/usuario.js') }}"></script>
@endsection
