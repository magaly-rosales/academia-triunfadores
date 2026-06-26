@extends('layouts.admin')

@section('title', 'Nuevo producto')

@section('content')

<div class="page-header">
    <div>
        <h4>Nuevo Producto</h4>
        <p>Agrega un nuevo producto a la tienda</p>
    </div>
    <a href="{{ route('admin.productos.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Volver
    </a>
</div>

<div class="card card-admin">
    <div class="card-body p-4">
        <form action="{{ route('admin.productos.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row g-4">
                <div class="col-md-8">
                    <label class="form-label fw-semibold">Nombre del producto *</label>
                    <input type="text" name="nombre" value="{{ old('nombre') }}"
                           class="form-control @error('nombre') is-invalid @enderror" required>
                    @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Categoría</label>
                    <input type="text" name="categoria" value="{{ old('categoria') }}"
                           class="form-control" placeholder="Ej: Libros, Cuadernos...">
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
                    <label class="form-label fw-semibold">Stock *</label>
                    <input type="number" name="stock" value="{{ old('stock', 0) }}"
                           class="form-control @error('stock') is-invalid @enderror" required>
                    @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Estado *</label>
                    <select name="estado" class="form-select" required>
                        <option value="activo"   {{ old('estado') === 'activo'   ? 'selected' : '' }}>Activo</option>
                        <option value="inactivo" {{ old('estado') === 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                    </select>
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold">Imagen del producto</label>
                    <input type="file" name="imagen" class="form-control" accept="image/*">
                    <small class="text-muted">Formatos: JPG, PNG. Máximo 2 MB.</small>
                </div>
            </div>

            <hr class="my-4">

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.productos.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg"></i> Crear producto
                </button>
            </div>
        </form>
    </div>
</div>

@endsection