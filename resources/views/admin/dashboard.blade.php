@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

<div class="page-header">
    <div>
        <h4>Bienvenido, {{ auth()->user()->name }} 👋</h4>
        <p>Panel de administración</p>
    </div>
</div>

{{-- Tarjetas de estadísticas --}}
<div class="row g-4 mb-5">
    <div class="col-md-3">
        <div class="card card-admin p-4">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-3 p-3 bg-primary bg-opacity-10">
                    <i class="bi bi-people-fill text-primary fs-4"></i>
                </div>
                <div>
                    <p class="text-muted small mb-0">Alumnos</p>
                    <h4 class="fw-bold mb-0">{{ \App\Models\Alumno::count() }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-admin p-4">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-3 p-3 bg-success bg-opacity-10">
                    <i class="bi bi-book-fill text-success fs-4"></i>
                </div>
                <div>
                    <p class="text-muted small mb-0">Cursos</p>
                    <h4 class="fw-bold mb-0">{{ \App\Models\Curso::count() }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-admin p-4">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-3 p-3 bg-warning bg-opacity-10">
                    <i class="bi bi-box-seam-fill text-warning fs-4"></i>
                </div>
                <div>
                    <p class="text-muted small mb-0">Productos</p>
                    <h4 class="fw-bold mb-0">{{ \App\Models\Producto::count() }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-admin p-4">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-3 p-3 bg-danger bg-opacity-10">
                    <i class="bi bi-cart-fill text-danger fs-4"></i>
                </div>
                <div>
                    <p class="text-muted small mb-0">Pedidos</p>
                    <h4 class="fw-bold mb-0">{{ \App\Models\Pedido::count() }}</h4>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Accesos rápidos --}}
<h5 class="fw-bold mb-3">Accesos rápidos</h5>
<div class="row g-3">
    <div class="col-md-4">
        <a href="/admin/cursos/create" class="card card-admin p-4 text-decoration-none text-dark d-flex flex-row align-items-center gap-3">
            <i class="bi bi-plus-circle-fill text-primary fs-3"></i>
            <span class="fw-semibold">Agregar nuevo curso</span>
        </a>
    </div>
    <div class="col-md-4">
        <a href="/admin/productos/create" class="card card-admin p-4 text-decoration-none text-dark d-flex flex-row align-items-center gap-3">
            <i class="bi bi-plus-circle-fill text-success fs-3"></i>
            <span class="fw-semibold">Agregar producto</span>
        </a>
    </div>
    <div class="col-md-4">
        <a href="/admin/pedidos" class="card card-admin p-4 text-decoration-none text-dark d-flex flex-row align-items-center gap-3">
            <i class="bi bi-eye-fill text-warning fs-3"></i>
            <span class="fw-semibold">Ver pedidos</span>
        </a>
    </div>
</div>

@endsection