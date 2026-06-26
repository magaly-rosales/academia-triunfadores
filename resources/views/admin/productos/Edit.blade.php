@extends('layouts.admin')

@section('title', 'Editar producto')

@section('content')

<div class="page-header">
    <div>
        <h4>Editar Producto</h4>
        <p>Modifica la información del producto #{{ $producto->id }}</p>
    </div>
    <a href="{{ route('admin.productos.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Volver
    </a>
</div>

<div class="card card-admin">
    <div class="card-body p-4">
        <form action="{{ route('admin.productos.update', $producto->id) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')

            <div class="row g-4">
                <div class="col-md-8">
                    <label class="form-label fw-semibold">Nombre del producto *</label>
                    <input type="text" name="nombre" value="{{ old('nombre', $producto->nombre) }}"
                           class="form-control @error('nombre') is-invalid @enderror" required>
                    @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Categoría</label>
                    <input type="text" name="categoria" value="{{ old('categoria', $producto->categoria) }}"
                           class="form-control">
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold">Descripción</label>
                    <textarea name="descripcion" rows="3"
                              class="form-control">{{ old('descripcion', $producto->descripcion) }}</textarea>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Precio (S/) *</label>
                    <input type="number" step="0.01" name="precio" value="{{ old('precio', $producto->precio) }}"
                           class="form-control @error('precio') is-invalid @enderror" required>
                    @error('precio')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Stock *</label>
                    <input type="number" name="stock" value="{{ old('stock', $producto->stock) }}"
                           class="form-control @error('stock') is-invalid @enderror" required>
                    @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Estado *</label>
                    <select name="estado" class="form-select" required>
                        <option value="activo"   {{ old('estado', $producto->estado) === 'activo'   ? 'selected' : '' }}>Activo</option>
                        <option value="inactivo" {{ old('estado', $producto->estado) === 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                    </select>
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold">Imagen del producto</label>
                    @if($producto->imagen)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $producto->imagen) }}"
                                 style="width:100px;height:100px;object-fit:cover;border-radius:8px;">
                            <p class="small text-muted mt-1 mb-0">Imagen actual</p>
                        </div>
                    @endif
                    <input type="file" name="imagen" class="form-control" accept="image/*">
                    <small class="text-muted">Deja vacío para mantener la imagen actual. Máximo 2 MB.</small>
                </div>
            </div>

            <hr class="my-4">

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.productos.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg"></i> Guardar cambios
                </button>
            </div>
        </form>
    </div>
</div>

@endsection