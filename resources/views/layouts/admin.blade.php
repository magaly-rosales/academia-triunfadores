<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel') — Academia Triunfadores</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body { background: #f1f5f9; font-family: 'Segoe UI', system-ui, sans-serif; }

        /* SIDEBAR */
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);
            width: 260px;
            position: fixed;
            top: 0; left: 0;
            box-shadow: 4px 0 12px rgba(0,0,0,0.05);
        }
        .sidebar .logo {
            color: #fff;
            font-size: 1.15rem;
            font-weight: 700;
            padding: 24px 22px;
            border-bottom: 1px solid #334155;
            display: flex;
            align-items: center;
        }
        .sidebar .logo i {
            font-size: 1.5rem;
            color: #3b82f6;
            margin-right: 10px;
        }
        .sidebar .nav-section {
            padding: 16px 22px 8px;
            font-size: 0.7rem;
            text-transform: uppercase;
            color: #64748b;
            letter-spacing: 1px;
            font-weight: 600;
        }
        .sidebar .nav-link {
            color: #cbd5e1;
            padding: 11px 18px;
            border-radius: 8px;
            margin: 2px 12px;
            font-size: 0.92rem;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
        }
        .sidebar .nav-link i { margin-right: 12px; font-size: 1.05rem; }
        .sidebar .nav-link:hover {
            background: rgba(255,255,255,0.06);
            color: #fff;
        }
        .sidebar .nav-link.active {
            background: linear-gradient(90deg, #3b82f6 0%, #2563eb 100%);
            color: #fff;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        /* CONTENT */
        .main-content {
            margin-left: 260px;
            padding: 32px 40px;
            min-height: 100vh;
        }
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 28px;
            padding-bottom: 20px;
            border-bottom: 1px solid #e2e8f0;
        }
        .page-header h4 {
            color: #0f172a;
            margin-bottom: 4px;
            font-weight: 700;
        }
        .page-header p { color: #64748b; margin-bottom: 0; font-size: 0.9rem; }

        /* CARDS */
        .card-admin {
            border: none;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05), 0 1px 2px rgba(0,0,0,0.03);
            background: #fff;
        }

        /* USER INFO EN SIDEBAR */
        .sidebar-user {
            position: absolute;
            bottom: 0; left: 0; right: 0;
            padding: 16px 22px;
            border-top: 1px solid #334155;
            background: rgba(0,0,0,0.2);
        }
        .sidebar-user .user-name { color: #fff; font-weight: 600; font-size: 0.9rem; }
        .sidebar-user .user-role { color: #94a3b8; font-size: 0.75rem; }
    </style>

    @stack('styles')
</head>
<body>

{{-- SIDEBAR --}}
<aside class="sidebar d-flex flex-column">
    <div class="logo">
        <i class="bi bi-mortarboard-fill"></i>
        <span>Academia Admin</span>
    </div>

    <nav class="nav flex-column mt-2">
        <div class="nav-section">Principal</div>
        <a href="/admin/dashboard"
           class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        <div class="nav-section">Gestión</div>
        <a href="/admin/pedidos"
           class="nav-link {{ request()->is('admin/pedidos*') ? 'active' : '' }}">
            <i class="bi bi-cart-check"></i> Pedidos
        </a>
        <a href="/admin/productos"
           class="nav-link {{ request()->is('admin/productos*') ? 'active' : '' }}">
            <i class="bi bi-box-seam"></i> Productos
        </a>
        <a href="/admin/cursos"
           class="nav-link {{ request()->is('admin/cursos*') ? 'active' : '' }}">
            <i class="bi bi-book"></i> Cursos
        </a>
        <a href="/admin/alumnos"
           class="nav-link {{ request()->is('admin/alumnos*') ? 'active' : '' }}">
            <i class="bi bi-people"></i> Alumnos
        </a>
        <a href="/admin/blog"
           class="nav-link {{ request()->is('admin/blog*') ? 'active' : '' }}">
            <i class="bi bi-journal-text"></i> Blog
        </a>

        <div class="nav-section">Otros</div>
        <a href="/" class="nav-link" target="_blank">
            <i class="bi bi-box-arrow-up-right"></i> Ver sitio web
        </a>
    </nav>

    {{-- USER INFO --}}
    <div class="sidebar-user">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <div class="user-name">
                    <i class="bi bi-person-circle"></i> {{ auth()->user()->name }}
                </div>
                <div class="user-role">Administrador</div>
            </div>
            <form action="/logout" method="POST" class="m-0">
                @csrf
                <button type="submit" class="btn btn-sm text-danger border-0 bg-transparent"
                        title="Cerrar sesión">
                    <i class="bi bi-box-arrow-right fs-5"></i>
                </button>
            </form>
        </div>
    </div>
</aside>

{{-- CONTENIDO --}}
<main class="main-content">

    {{-- Alertas --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bi bi-x-circle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Aquí va el contenido de cada vista --}}
    @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>