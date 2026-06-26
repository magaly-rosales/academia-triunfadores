<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Academia Triunfadores')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
        }

        /* NAVBAR */
        .navbar-brand {
            font-size: 1.25rem;
        }

        .navbar .nav-link {
            font-weight: 500;
            padding: 0.5rem 0.85rem !important;
            border-radius: 6px;
            transition: all 0.2s ease;
        }

        .navbar .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #fff !important;
        }

        .navbar .nav-link.active {
            background: rgba(13, 110, 253, 0.2);
            color: #fff !important;
        }

        /* Dropdown items */
        .dropdown-menu {
            border-radius: 10px;
            padding: 0.5rem;
        }

        .dropdown-item {
            border-radius: 6px;
            transition: background 0.15s ease;
        }

        .dropdown-item:hover {
            background: #f1f5f9;
        }

        /* CARRITO BADGE */
        .carrito-btn {
            position: relative;
        }

        .carrito-badge {
            position: absolute;
            top: -6px;
            right: -8px;
            background: #ef4444;
            color: #fff;
            font-size: 10px;
            font-weight: bold;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #1f2937;
        }

        /* FOOTER */
        footer {
            background: #1e293b;
            color: #94a3b8;
        }

        footer a {
            color: #94a3b8;
            text-decoration: none;
        }

        footer a:hover {
            color: #fff;
        }
    </style>
    @yield('styles')
</head>

<body>

    {{-- NAVBAR --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm sticky-top py-3">
        <div class="container-fluid px-4 px-lg-5">

            {{-- LOGO IZQUIERDA --}}
            <a class="navbar-brand text-white d-flex align-items-center" href="/">
                <i class="bi bi-mortarboard-fill me-2 text-primary fs-4"></i>
                <span class="fw-bold">Academia Triunfadores</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">

                {{-- MENÚ CENTRADO (con mx-auto) --}}
                <ul class="navbar-nav ms-auto me-3">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('/') ? 'active fw-semibold' : '' }}" href="/">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('nosotros') ? 'active fw-semibold' : '' }}" href="/nosotros">Nosotros</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('galeria') ? 'active fw-semibold' : '' }}" href="/galeria">Galería</a>
                    </li>

                    {{-- Tienda: SIEMPRE visible --}}
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('tienda*') ? 'active fw-semibold' : '' }}" href="/tienda">Tienda</a>
                    </li>

                    {{-- Cursos y Blog: SOLO para logueados --}}
                    @auth
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('cursos*') ? 'active fw-semibold' : '' }}" href="/cursos">Cursos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('blog*') ? 'active fw-semibold' : '' }}" href="/blog">Blog</a>
                    </li>
                    @endauth

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('contactos') ? 'active fw-semibold' : '' }}" href="/contactos">Contacto</a>
                    </li>
                </ul>

                {{-- DERECHA: carrito + cuenta --}}
                <ul class="navbar-nav align-items-center gap-2">

                    @auth
                    {{-- Carrito SOLO si está logueado --}}
                    <li class="nav-item">
                        <a href="/carrito" class="btn btn-outline-light btn-sm carrito-btn position-relative">
                            <i class="bi bi-cart3 fs-5"></i>
                            @php
                            $totalCarrito = \App\Models\CarritoItem::where('user_id', auth()->id())->sum('cantidad');
                            @endphp
                            @if($totalCarrito > 0)
                            <span class="carrito-badge">{{ $totalCarrito }}</span>
                            @endif
                        </a>
                    </li>

                    {{-- Dropdown del usuario logueado --}}
                    <li class="nav-item dropdown">
                        <a class="btn btn-primary btn-sm dropdown-toggle d-flex align-items-center gap-2"
                            href="#" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle"></i>
                            <span>{{ auth()->user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                            @if(auth()->user()->role === 'admin')
                            <li>
                                <a class="dropdown-item py-2" href="/admin/dashboard">
                                    <i class="bi bi-speedometer2 me-2 text-primary"></i>Panel Admin
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            @endif
                            <li>
                                <a class="dropdown-item py-2" href="/mis-pedidos">
                                    <i class="bi bi-bag me-2 text-success"></i>Mis pedidos
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form action="/logout" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item py-2 text-danger">
                                        <i class="bi bi-box-arrow-left me-2"></i>Cerrar sesión
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                    @else
                    {{-- Dropdown "Mi cuenta" para invitados --}}
                    <li class="nav-item dropdown">
                        <a class="btn btn-primary btn-sm dropdown-toggle d-flex align-items-center gap-2"
                            href="#" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle"></i>
                            <span>Mi cuenta</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2" style="min-width:220px;">
                            <li>
                                <a class="dropdown-item py-2"
                                    href="{{ url('/login') }}"
                                    {{ $modoApp ? 'target="_system"' : '' }}>
                                    <i class="bi bi-box-arrow-in-right me-2 text-primary"></i>Iniciar sesión
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item py-2"
                                    href="{{ url('/register') }}"
                                    {{ $modoApp ? 'target="_system"' : '' }}>
                                    <i class="bi bi-person-plus me-2 text-success"></i>Registrarse
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li class="px-3 py-1">
                                <small class="text-muted">
                                    @if($modoApp)
                                    Iniciar sesión abrirá tu navegador.
                                    @else
                                    Inicia sesión para comprar y acceder a cursos.
                                    @endif
                                </small>
                            </li>
                        </ul>
                    </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    {{-- MENSAJES GLOBALES --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-0 rounded-0">
        <div class="container">{{ session('success') }}</div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show mb-0 rounded-0">
        <div class="container">{{ session('error') }}</div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{-- CONTENIDO DE CADA PÁGINA --}}
    <main>
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer class="mt-5 py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <h5 class="text-white fw-bold mb-3">
                        <i class="bi bi-mortarboard-fill me-2 text-primary"></i>Academia Triunfadores
                    </h5>
                    <p class="small">Formando profesionales con los mejores cursos y materiales educativos.</p>
                </div>
                <div class="col-md-2">
                    <h6 class="text-white fw-semibold mb-3">Navegación</h6>
                    <ul class="list-unstyled small">
                        <li><a href="/">Inicio</a></li>
                        <li><a href="/nosotros">Nosotros</a></li>
                        <li><a href="/galeria">Galería</a></li>
                        <li><a href="/contactos">Contacto</a></li>
                    </ul>
                </div>
                <div class="col-md-2">
                    <h6 class="text-white fw-semibold mb-3">Aprende</h6>
                    <ul class="list-unstyled small">
                        <li><a href="/cursos">Cursos</a></li>
                        <li><a href="/tienda">Tienda</a></li>
                        <li><a href="/blog">Blog</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h6 class="text-white fw-semibold mb-3">Contacto</h6>
                    <ul class="list-unstyled small">
                        <li><i class="bi bi-geo-alt me-2"></i>Lima, Perú</li>
                        <li><i class="bi bi-envelope me-2"></i>info@academiatriunfadores.com</li>
                        <li><i class="bi bi-telephone me-2"></i>+51 932 345 456</li>
                    </ul>
                </div>
            </div>
            <hr style="border-color:#334155;" class="mt-4">
            <p class="text-center small mb-0">© {{ date('Y') }} Academia Triunfadores. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>

</html>