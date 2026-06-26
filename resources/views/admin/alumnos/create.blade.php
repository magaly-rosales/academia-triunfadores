@extends('layouts.admin')

@section('title', 'Nuevo alumno')

@section('content')

<div class="page-header">
    <div>
        <h4>Nuevo Alumno</h4>
        <p>Registra un alumno en la academia</p>
    </div>
    <a href="{{ route('admin.alumnos.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Volver
    </a>
</div>

<div class="card card-admin">
    <div class="card-body p-4">
        <form action="{{ route('admin.alumnos.store') }}" method="POST">
            @csrf

            <div class="row g-4">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Código *</label>
                    <input type="text" name="codigo" value="{{ old('codigo') }}"
                           class="form-control @error('codigo') is-invalid @enderror" required>
                    @error('codigo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Nombre *</label>
                    <input type="text" name="nombre" value="{{ old('nombre') }}"
                           class="form-control @error('nombre') is-invalid @enderror" required>
                    @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Apellido *</label>
                    <input type="text" name="apellido" value="{{ old('apellido') }}"
                           class="form-control @error('apellido') is-invalid @enderror" required>
                    @error('apellido')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Edad *</label>
                    <input type="number" name="edad" value="{{ old('edad') }}" min="1" max="120"
                           class="form-control @error('edad') is-invalid @enderror" required>
                    @error('edad')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-8">
                    <label class="form-label fw-semibold">Curso *</label>
                    <input type="text" name="curso" value="{{ old('curso') }}"
                           class="form-control @error('curso') is-invalid @enderror" required>
                    @error('curso')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <hr class="my-4">

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.alumnos.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg"></i> Registrar alumno
                </button>
            </div>
        </form>
    </div>
</div>

@endsection