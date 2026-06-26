<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body{
            background-color:#f4f6f9;
        }
        .navbar{
            background-color:#0d6efd;
        }
        .navbar-brand{
            color:white !important;
            font-weight:bold;
            font-size:24px;
        }
        .nav-link{
            color:white !important;
            font-weight:500;
        }
        .card{
            border:none;
            border-radius:10px;
            box-shadow:0px 3px 12px rgba(0,0,0,0.1);
        }
        .contenido{
            margin-top:30px;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="/dashboard">
            Academia
        </a>
        <div class="d-flex align-items-center gap-3">
            <a href="/dashboard" class="nav-link">
                Dashboard
            </a>
            <a href="/alumnos" class="nav-link">
                Alumnos
            </a>
            <form action="/logout" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm">
                    Cerrar Sesión
                </button>
            </form>
        </div>
    </div>
</nav>
<div class="container contenido">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @yield('content')
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>