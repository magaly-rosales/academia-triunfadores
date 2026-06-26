@extends('layouts.admin')

@section('title', 'Nuevo curso')

@section('content')

<div class="page-header">
    <div>
        <h4>Nuevo Curso</h4>
        <p>Agrega un nuevo curso al catálogo</p>
    </div>
    <a href="{{ route('admin.cursos.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Volver
    </a>
</div>

<div class="card card-admin">
    <div class="card-body p-4">
        <form action="{{ route('admin.cursos.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row g-4">
                <div class="col-md-8">
                    <label class="form-label fw-semibold">Nombre del curso *</label>
                    <input type="text" name="nombre" value="{{ old('nombre') }}"
                           class="form-control @error('nombre') is-invalid @enderror" required>
                    @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Categoría</label>
                    <input type="text" name="categoria" value="{{ old('categoria') }}"
                           class="form-control" placeholder="Ej: Programación, Inglés...">
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold">Descripción</label>
                    <textarea name="descripcion" rows="3"
                              class="form-control">{{ old('descripcion') }}</textarea>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Precio (S/) *</label>
                    <input type="number" step="0.01" name="precio" value="{{ old('precio') }}"
                           class="form-control @error('precio') is-invalid @enderror" required>
                    @error('precio')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Duración</label>
                    <input type="text" name="duracion" value="{{ old('duracion') }}"
                           class="form-control" placeholder="Ej: 8 semanas, 20 horas...">
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Nivel *</label>
                    <select name="nivel" class="form-select" required>
                        <option value="básico"     {{ old('nivel') === 'básico'     ? 'selected' : '' }}>Básico</option>
                        <option value="intermedio" {{ old('nivel') === 'intermedio' ? 'selected' : '' }}>Intermedio</option>
                        <option value="avanzado"   {{ old('nivel') === 'avanzado'   ? 'selected' : '' }}>Avanzado</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Estado *</label>
                    <select name="estado" class="form-select" required>
                        <option value="activo"   {{ old('estado') === 'activo'   ? 'selected' : '' }}>Activo</option>
                        <option value="inactivo" {{ old('estado') === 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Imagen del curso</label>
                    <input type="file" name="imagen" class="form-control" accept="image/*">
                    <small class="text-muted">Formatos: JPG, PNG. Máximo 2 MB.</small>
                </div>
            </div>

            <hr class="my-4">

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.cursos.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg"></i> Crear curso
                </button>
            </div>
        </form>
    </div>
</div>

@endsection