@extends('layouts.publica')

@section('title', 'Mi cuenta — Academia Triunfadores')

@section('content')
<div class="container py-5">

    {{-- Saludo --}}
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h4 class="fw-bold mb-0">Hola, {{ auth()->user()->name }} 👋</h4>
            <p class="text-muted mb-0">Bienvenido a tu cuenta</p>
        </div>
    </div>

    {{-- Tarjetas de acceso rápido --}}
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <a href="/cursos" class="card border-0 shadow-sm rounded-4 text-decoration-none text-dark h-100">
                <div class="card-body p-4 d-flex align-items-center gap-3">
                    <div class="rounded-3 p-3 bg-primary bg-opacity-10">
                        <i class="bi bi-mortarboard-fill text-primary fs-3"></i>
                    </div>
                    <div>
                        <p class="fw-bold mb-0">Ver Cursos</p>
                        <small class="text-muted">Explora el catálogo</small>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="/tienda" class="card border-0 shadow-sm rounded-4 text-decoration-none text-dark h-100">
                <div class="card-body p-4 d-flex align-items-center gap-3">
                    <div class="rounded-3 p-3 bg-success bg-opacity-10">
                        <i class="bi bi-box-seam-fill text-success fs-3"></i>
                    </div>
                    <div>
                        <p class="fw-bold mb-0">Ver Tienda</p>
                        <small class="text-muted">Libros y materiales</small>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="/mis-pedidos" class="card border-0 shadow-sm rounded-4 text-decoration-none text-dark h-100">
                <div class="card-body p-4 d-flex align-items-center gap-3">
                    <div class="rounded-3 p-3 bg-warning bg-opacity-10">
                        <i class="bi bi-bag-fill text-warning fs-3"></i>
                    </div>
                    <div>
                        <p class="fw-bold mb-0">Mis Pedidos</p>
                        <small class="text-muted">Historial de compras</small>
                    </div>
                </div>
            </a>
        </div>
    </div>

    {{-- Carrito activo --}}
    @php $carrito = session('carrito', []); @endphp
    @if(count($carrito) > 0)
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0">
                    <i class="bi bi-cart3 me-2 text-primary"></i>Tienes {{ count($carrito) }} ítem(s) en tu carrito
                </h5>
                <a href="/carrito" class="btn btn-primary btn-sm">Ver carrito</a>
            </div>
            <div class="d-flex flex-wrap gap-2">
                @foreach($carrito as $item)
                    <span class="badge bg-light text-dark border px-3 py-2">
                        {{ $item['nombre'] }}
                        <span class="badge {{ $item['tipo'] === 'curso' ? 'bg-primary' : 'bg-success' }} ms-1">
                            {{ $item['tipo'] }}
                        </span>
                        — S/ {{ number_format($item['precio'], 2) }}
                    </span>
                @endforeach
            </div>
            <div class="mt-3">
                <form action="/carrito/confirmar" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle me-1"></i>Confirmar pedido ahora
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endif

    {{-- Info cuenta --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <h5 class="fw-bold mb-3">Datos de mi cuenta</h5>
            <div class="row g-3">
                <div class="col-md-6">
                    <p class="text-muted small mb-1">Nombre</p>
                    <p class="fw-semibold mb-0">{{ auth()->user()->name }}</p>
                </div>
                <div class="col-md-6">
                    <p class="text-muted small mb-1">Correo</p>
                    <p class="fw-semibold mb-0">{{ auth()->user()->email }}</p>
                </div>
                <div class="col-md-6">
                    <p class="text-muted small mb-1">Tipo de cuenta</p>
                    <span class="badge bg-primary-subtle text-primary">{{ auth()->user()->role }}</span>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection