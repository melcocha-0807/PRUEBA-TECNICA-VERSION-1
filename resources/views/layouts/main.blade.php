<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Tienda Virtual')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    {{-- Barra de navegación --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('welcome') }}">Tienda</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    @auth
                        @if(auth()->user()->rol === 'usuario')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('usuario.home') }}">Inicio</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('carrito.index') }}">Carrito</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('usuario.catalogo') }}">Catálogo</a>
                            </li>
                        @elseif(auth()->user()->rol === 'vendedor')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('vendedor.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('vendedor.panel') }}">Panel de Ventas</a>
                            </li>
                        @elseif(auth()->user()->rol === 'auxiliar de bodega' || auth()->user()->rol === 'auxiliar')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('auxiliar.dashboard') }}">Dashboard Auxiliar</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('auxiliar.productos') }}">Productos</a>
                            </li>
                        @endif
                    @endauth
                </ul>

                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item">
                            <span class="nav-link">Hola, {{ auth()->user()->nombres }}</span>
                        </li>
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-link nav-link">Cerrar sesión</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Iniciar sesión</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Registrarse</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    {{-- Contenido principal --}}
    <main class="container py-4">
        @yield('content')
    </main>

    {{-- Mensajes flash --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show container mt-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show container mt-3" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-warning alert-dismissible fade show container mt-3" role="alert">
            <strong>Revisa los errores:</strong>
            <ul class="mb-0 mt-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    {{-- Footer (opcional) --}}
    <footer class="text-center mt-5 mb-3 text-muted small">
        &copy; {{ date('Y') }} Tienda Virtual. Todos los derechos reservados.
    </footer>

    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
