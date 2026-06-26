@extends('layouts.admin')

@section('title', 'Blog')

@section('content')

<div class="page-header">
    <div>
        <h4>Gestión del Blog</h4>
        <p>Administra los artículos publicados</p>
    </div>
    <a href="{{ route('admin.blog.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Nuevo artículo
    </a>
</div>

{{-- BUSCADOR Y FILTROS --}}
<div class="card card-admin p-3 mb-4">
    <form method="GET" action="{{ route('admin.blog.lista') }}" class="row g-2 align-items-end">
        <div class="col-md-6">
            <label class="form-label small text-muted mb-1">Buscar</label>
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                <input type="text" name="buscar" value="{{ request('buscar') }}"
                       class="form-control border-start-0"
                       placeholder="Título o categoría del artículo...">
            </div>
        </div>
        <div class="col-md-4">
            <label class="form-label small text-muted mb-1">Estado</label>
            <select name="estado" class="form-select">
                <option value="">Todos</option>
                <option value="publicado" {{ request('estado') === 'publicado' ? 'selected' : '' }}>Publicados</option>
                <option value="borrador"  {{ request('estado') === 'borrador'  ? 'selected' : '' }}>Borradores</option>
            </select>
        </div>
        <div class="col-md-2 d-flex gap-2">
            <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-funnel"></i> Filtrar
            </button>
            @if(request('buscar') || request('estado'))
                <a href="{{ route('admin.blog.lista') }}" class="btn btn-outline-secondary" title="Limpiar">
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
                    <th>Título</th>
                    <th>Categoría</th>
                    <th>Estado</th>
                    <th>Publicado</th>
                    <th class="text-end pe-4">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($posts as $post)
                <tr>
                    <td class="ps-4">
                        @if($post->imagen)
                            <img src="{{ asset('storage/' . $post->imagen) }}"
                                 style="width:60px;height:50px;object-fit:cover;border-radius:8px;">
                        @else
                            <div style="width:60px;height:50px;background:#f1f5f9;border-radius:8px;display:flex;align-items:center;justify-content:center;">
                                <i class="bi bi-journal-text text-muted"></i>
                            </div>
                        @endif
                    </td>
                    <td>
                        <div class="fw-semibold">{{ $post->titulo }}</div>
                        <div class="small text-muted">{{ Str::limit($post->resumen, 60) }}</div>
                    </td>
                    <td>
                        @if($post->categoria)
                            <span class="badge bg-light text-dark">{{ $post->categoria }}</span>
                        @else
                            <span class="text-muted small">—</span>
                        @endif
                    </td>
                    <td>
                        @if($post->estado === 'publicado')
                            <span class="badge bg-success-subtle text-success">
                                <i class="bi bi-check-circle"></i> Publicado
                            </span>
                        @else
                            <span class="badge bg-warning-subtle text-warning">
                                <i class="bi bi-pencil"></i> Borrador
                            </span>
                        @endif
                    </td>
                    <td class="small text-muted">
                        {{ $post->publicado_en ? \Carbon\Carbon::parse($post->publicado_en)->format('d/m/Y') : '—' }}
                    </td>
                    <td class="text-end pe-4">
                        <a href="{{ route('admin.blog.edit', $post->id) }}"
                           class="btn btn-sm btn-outline-primary" title="Editar">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('admin.blog.destroy', $post->id) }}"
                              method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                    onclick="return confirm('¿Eliminar este artículo?')"
                                    title="Eliminar">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5 text-muted">
                        <i class="bi bi-journal-x fs-1 d-block mb-2"></i>
                        No se encontraron artículos
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $posts->links() }}
</div>

@endsection