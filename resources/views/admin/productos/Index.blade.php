@extends('layouts.admin')

@section('title', 'Productos')

@section('content')

<div class="page-header">
    <div>
        <h4>Gestión de Productos</h4>
        <p>Administra la tienda de la academia</p>
    </div>
    <a href="{{ route('admin.productos.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Nuevo producto
    </a>
</div>

{{-- BUSCADOR Y FILTROS --}}
<div class="card card-admin p-3 mb-4">
    <form method="GET" action="{{ route('admin.productos.index') }}" class="row g-2 align-items-end">
        <div class="col-md-6">
            <label class="form-label small text-muted mb-1">Buscar</label>
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                <input type="text" name="buscar" value="{{ request('buscar') }}"
                       class="form-control border-start-0"
                       placeholder="Nombre o categoría del producto...">
            </div>
        </div>
        <div class="col-md-4">
            <label class="form-label small text-muted mb-1">Estado</label>
            <select name="estado" class="form-select">
                <option value="">Todos</option>
                <option value="activo"   {{ request('estado') === 'activo'   ? 'selected' : '' }}>Activos</option>
                <option value="inactivo" {{ request('estado') === 'inactivo' ? 'selected' : '' }}>Inactivos</option>
            </select>
        </div>
        <div class="col-md-2 d-flex gap-2">
            <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-funnel"></i> Filtrar
            </button>
            @if(request('buscar') || request('estado'))
                <a href="{{ route('admin.productos.index') }}" class="btn btn-outline-secondary" title="Limpiar">
                    <i class="bi bi-x-lg"></i>
                </a>
            @endif
        </div>
    </form>
</div>

{{-- TABLA --}}
<div class="card card-admin">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4">Imagen</th>
                    <th>Nombre</th>
                    <th>Categoría</th>
                    <th class="text-end">Precio</th>
                    <th class="text-center">Stock</th>
                    <th>Estado</th>
                    <th class="text-end pe-4">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($productos as $producto)
                <tr>
                    <td class="ps-4">
                        @if($producto->imagen)
                            <img src="{{ asset('storage/' . $producto->imagen) }}"
                                 style="width:50px;height:50px;object-fit:cover;border-radius:8px;">
                        @else
                            <div style="width:50px;height:50px;background:#f1f5f9;border-radius:8px;display:flex;align-items:center;justify-content:center;">
                                <i class="bi bi-image text-muted"></i>
                            </div>
                        @endif
                    </td>
                    <td>
                        <div class="fw-semibold">{{ $producto->nombre }}</div>
                        <div class="small text-muted">{{ Str::limit($producto->descripcion, 50) }}</div>
                    </td>
                    <td>
                        @if($producto->categoria)
                            <span class="badge bg-light text-dark">{{ $producto->categoria }}</span>
                        @else
                            <span class="text-muted small">—</span>
                        @endif
                    </td>
                    <td class="text-end fw-bold">S/ {{ number_format($producto->precio, 2) }}</td>
                    <td class="text-center">
                        @if($producto->stock <= 0)
                            <span class="badge bg-danger">Sin stock</span>
                        @elseif($producto->stock < 5)
                            <span class="badge bg-warning text-dark">{{ $producto->stock }} (bajo)</span>
                        @else
                            <span class="badge bg-success">{{ $producto->stock }}</span>
                        @endif
                    </td>
                    <td>
                        @if($producto->estado === 'activo')
                            <span class="badge bg-success-subtle text-success">Activo</span>
                        @else
                            <span class="badge bg-secondary-subtle text-secondary">Inactivo</span>
                        @endif
                    </td>
                    <td class="text-end pe-4">
                        <a href="{{ route('admin.productos.edit', $producto->id) }}"
                           class="btn btn-sm btn-outline-primary" title="Editar">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('admin.productos.destroy', $producto->id) }}"
                              method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                    onclick="return confirm('¿Eliminar este producto?')"
                                    title="Eliminar">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                        No se encontraron productos
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $productos->links() }}
</div>

@endsection