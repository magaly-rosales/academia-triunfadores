<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse — Academia Triunfadores</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
            padding: 30px 0;
        }
        .register-card {
            background: #fff;
            border-radius: 20px;
            padding: 45px 40px;
            width: 100%;
            max-width: 460px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        .logo-icon {
            width: 64px; height: 64px;
            background: linear-gradient(135deg, #10b981, #059669);
            border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            font-size: 28px; color: #fff;
            margin: 0 auto 20px;
        }
        .form-control {
            border-radius: 10px;
            border: 1.5px solid #e2e8f0;
            padding: 12px 15px;
            font-size: 15px;
            transition: border-color .2s, box-shadow .2s;
        }
        .form-control:focus {
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16,185,129,.15);
        }
        .btn-register {
            background: linear-gradient(135deg, #10b981, #059669);
            border: none; border-radius: 10px;
            padding: 13px; font-size: 16px; font-weight: 600;
            color: #fff; width: 100%;
            transition: opacity .2s, transform .1s;
        }
        .btn-register:hover { opacity: .9; transform: translateY(-1px); color: #fff; }
        .divider { border-color: #e2e8f0; }
        .input-group-text {
            background: #f8fafc; border: 1.5px solid #e2e8f0;
            border-right: none; border-radius: 10px 0 0 10px; color: #94a3b8;
        }
        .input-group .form-control { border-left: none; border-radius: 0 10px 10px 0; }
    </style>
</head>
<body>
<div class="register-card">
    {{-- Logo --}}
    <div class="logo-icon">
        <i class="bi bi-person-plus-fill"></i>
    </div>
    <h4 class="text-center fw-bold mb-1">Crea tu cuenta</h4>
    <p class="text-center text-muted small mb-4">Únete a Academia Triunfadores</p>

    {{-- Errores --}}
    @if($errors->any())
        <div class="alert alert-danger rounded-3 py-2 small">
            <i class="bi bi-exclamation-triangle me-1"></i>
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="/register" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label fw-semibold small">Nombre completo</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-person"></i></span>
                <input type="text" name="name" value="{{ old('name') }}"
                       class="form-control" placeholder="Tu nombre" required autofocus>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold small">Correo electrónico</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                <input type="email" name="email" value="{{ old('email') }}"
                       class="form-control" placeholder="tu@correo.com" required>
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label fw-semibold small">Contraseña</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                <input type="password" name="password"
                       class="form-control" placeholder="Mínimo 6 caracteres" required>
            </div>
        </div>

        <button type="submit" class="btn-register mb-3">
            <i class="bi bi-person-check me-2"></i>Crear cuenta
        </button>
    </form>

    <hr class="divider">

    <p class="text-center text-muted small mb-0">
        ¿Ya tienes cuenta?
        <a href="/login" class="text-success fw-semibold text-decoration-none">Inicia sesión</a>
    </p>
    <p class="text-center mt-2 mb-0">
        <a href="/" class="text-muted small text-decoration-none">
            <i class="bi bi-arrow-left me-1"></i>Volver al inicio
        </a>
    </p>
</div>
</body>
</html>