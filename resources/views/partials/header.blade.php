<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">Mi Aplicación</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                @auth
                    @if(Auth::user()->rol === 'usuario')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('usuario.catalogo') }}">Catálogo</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('carrito.index') }}">Carrito</a>
                        </li>
                    @elseif(Auth::user()->rol === 'vendedor')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('vendedor.panel') }}">Panel de Ventas</a>
                        </li>
                    @elseif(Auth::user()->rol === 'auxiliar de bodega' || Auth::user()->rol === 'auxiliar')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('auxiliar.dashboard') }}">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('auxiliar.productos') }}">Productos</a>
                        </li>
                    @endif

                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-link nav-link" style="border: none;">Cerrar sesión</button>
                        </form>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Iniciar Sesión</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
