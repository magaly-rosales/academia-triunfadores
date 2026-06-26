@extends('layouts.admin')

@section('title', 'Editar artículo')

@section('content')

<div class="page-header">
    <div>
        <h4>Editar Artículo</h4>
        <p>Modifica el artículo #{{ $post->id }}</p>
    </div>
    <a href="{{ route('admin.blog.lista') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Volver
    </a>
</div>

<div class="card card-admin">
    <div class="card-body p-4">
        <form action="{{ route('admin.blog.update', $post->id) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')

            <div class="row g-4">
                <div class="col-md-8">
                    <label class="form-label fw-semibold">Título *</label>
                    <input type="text" name="titulo" value="{{ old('titulo', $post->titulo) }}"
                           class="form-control @error('titulo') is-invalid @enderror" required>
                    @error('titulo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Categoría</label>
                    <input type="text" name="categoria" value="{{ old('categoria', $post->categoria) }}"
                           class="form-control">
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold">Resumen</label>
                    <textarea name="resumen" rows="2" maxlength="500"
                              class="form-control">{{ old('resumen', $post->resumen) }}</textarea>
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold">Contenido *</label>
                    <textarea name="contenido" rows="10"
                              class="form-control @error('contenido') is-invalid @enderror" required>{{ old('contenido', $post->contenido) }}</textarea>
                    @error('contenido')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Estado *</label>
                    <select name="estado" class="form-select" required>
                        <option value="borrador"  {{ old('estado', $post->estado) === 'borrador'  ? 'selected' : '' }}>Borrador</option>
                        <option value="publicado" {{ old('estado', $post->estado) === 'publicado' ? 'selected' : '' }}>Publicado</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Imagen destacada</label>
                    @if($post->imagen)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $post->imagen) }}"
                                 style="width:120px;height:80px;object-fit:cover;border-radius:8px;">
                            <p class="small text-muted mt-1 mb-0">Imagen actual</p>
                        </div>
                    @endif
                    <input type="file" name="imagen" class="form-control" accept="image/*">
                    <small class="text-muted">Deja vacío para mantener la imagen actual.</small>
                </div>
            </div>

            <hr class="my-4">

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.blog.lista') }}" class="btn btn-outline-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg"></i> Guardar cambios
                </button>
            </div>
        </form>
    </div>
</div>

@endsection