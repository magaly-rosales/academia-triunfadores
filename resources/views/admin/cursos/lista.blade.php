@extends('layouts.admin')

@section('title', 'Cursos')

@section('content')

<div class="page-header">
    <div>
        <h4>Gestión de Cursos</h4>
        <p>Administra el catálogo de cursos de la academia</p>
    </div>
    <a href="{{ route('admin.cursos.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Nuevo curso
    </a>
</div>

{{-- BUSCADOR Y FILTROS --}}
<div class="card card-admin p-3 mb-4">
    <form method="GET" action="{{ route('admin.cursos.index') }}" class="row g-2 align-items-end">
        <div class="col-md-6">
            <label class="form-label small text-muted mb-1">Buscar</label>
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                <input type="text" name="buscar" value="{{ request('buscar') }}"
                       class="form-control border-start-0"
                       placeholder="Nombre o categoría del curso...">
            </div>
        </div>
        <div class="col-md-4">
            <label class="form-label small text-muted mb-1">Nivel</label>
            <select name="nivel" class="form-select">
                <option value="">Todos</option>
                <option value="básico"     {{ request('nivel') === 'básico'     ? 'selected' : '' }}>Básico</option>
                <option value="intermedio" {{ request('nivel') === 'intermedio' ? 'selected' : '' }}>Intermedio</option>
                <option value="avanzado"   {{ request('nivel') === 'avanzado'   ? 'selected' : '' }}>Avanzado</option>
            </select>
        </div>
        <div class="col-md-2 d-flex gap-2">
            <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-funnel"></i> Filtrar
            </button>
            @if(request('buscar') || request('nivel'))
                <a href="{{ route('admin.cursos.index') }}" class="btn btn-outline-secondary" title="Limpiar">
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
                    <th>Nivel</th>
                    <th>Duración</th>
                    <th class="text-end">Precio</th>
                    <th>Estado</th>
                    <th class="text-end pe-4">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($cursos as $curso)
                <tr>
                    <td class="ps-4">
                        @if($curso->imagen)
                            <img src="{{ asset('storage/' . $curso->imagen) }}"
                                 style="width:50px;height:50px;object-fit:cover;border-radius:8px;">
                        @else
                            <div style="width:50px;height:50px;background:#f1f5f9;border-radius:8px;display:flex;align-items:center;justify-content:center;">
                                <i class="bi bi-book text-muted"></i>
                            </div>
                        @endif
                    </td>
                    <td>
                        <div class="fw-semibold">{{ $curso->nombre }}</div>
                        <div class="small text-muted">{{ Str::limit($curso->descripcion, 50) }}</div>
                    </td>
                    <td>
                        @if($curso->categoria)
                            <span class="badge bg-light text-dark">{{ $curso->categoria }}</span>
                        @else
                            <span class="text-muted small">—</span>
                        @endif
                    </td>
                    <td>
                        @php
                            $colorNivel = ['básico' => 'success', 'intermedio' => 'warning', 'avanzado' => 'danger'][$curso->nivel] ?? 'secondary';
                        @endphp
                        <span class="badge bg-{{ $colorNivel }}-subtle text-{{ $colorNivel }}">{{ ucfirst($curso->nivel) }}</span>
                    </td>
                    <td class="small text-muted">{{ $curso->duracion ?? '—' }}</td>
                    <td class="text-end fw-bold">S/ {{ number_format($curso->precio, 2) }}</td>
                    <td>
                        @if($curso->estado === 'activo')
                            <span class="badge bg-success-subtle text-success">Activo</span>
                        @else
                            <span class="badge bg-secondary-subtle text-secondary">Inactivo</span>
                        @endif
                    </td>
                    <td class="text-end pe-4">
                        <a href="{{ route('admin.cursos.edit', $curso->id) }}"
                           class="btn btn-sm btn-outline-primary" title="Editar">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('admin.cursos.destroy', $curso->id) }}"
                              method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                    onclick="return confirm('¿Eliminar este curso?')"
                                    title="Eliminar">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-5 text-muted">
                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                        No se encontraron cursos
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $cursos->links() }}
</div>

@endsection