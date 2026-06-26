@extends('layouts.admin')

@section('title', 'Nuevo artículo')

@section('content')

<div class="page-header">
    <div>
        <h4>Nuevo Artículo</h4>
        <p>Publica un nuevo artículo en el blog</p>
    </div>
    <a href="{{ route('admin.blog.lista') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Volver
    </a>
</div>

<div class="card card-admin">
    <div class="card-body p-4">
        <form action="{{ route('admin.blog.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row g-4">
                <div class="col-md-8">
                    <label class="form-label fw-semibold">Título *</label>
                    <input type="text" name="titulo" value="{{ old('titulo') }}"
                           class="form-control @error('titulo') is-invalid @enderror" required>
                    @error('titulo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Categoría</label>
                    <input type="text" name="categoria" value="{{ old('categoria') }}"
                           class="form-control" placeholder="Ej: Educación, Tips...">
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold">Resumen</label>
                    <textarea name="resumen" rows="2" maxlength="500"
                              class="form-control" placeholder="Breve descripción del artículo (máx. 500 caracteres)">{{ old('resumen') }}</textarea>
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold">Contenido *</label>
                    <textarea name="contenido" rows="10"
                              class="form-control @error('contenido') is-invalid @enderror" required>{{ old('contenido') }}</textarea>
                    @error('contenido')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Estado *</label>
                    <select name="estado" class="form-select" required>
                        <option value="borrador"  {{ old('estado') === 'borrador'  ? 'selected' : '' }}>Borrador</option>
                        <option value="publicado" {{ old('estado') === 'publicado' ? 'selected' : '' }}>Publicado</option>
                    </select>
                    <small class="text-muted">"Publicado" lo muestra en el blog público.</small>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Imagen destacada</label>
                    <input type="file" name="imagen" class="form-control" accept="image/*">
                    <small class="text-muted">Formatos: JPG, PNG. Máx. 2 MB.</small>
                </div>
            </div>

            <hr class="my-4">

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.blog.lista') }}" class="btn btn-outline-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg"></i> Crear artículo
                </button>
            </div>
        </form>
    </div>
</div>

@endsection