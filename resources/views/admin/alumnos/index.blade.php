@extends('layouts.admin')

@section('title', 'Alumnos')

@section('content')

<div class="page-header">
    <div>
        <h4>Gestión de Alumnos</h4>
        <p>Lista de alumnos registrados en la academia</p>
    </div>
    <a href="{{ route('admin.alumnos.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Nuevo alumno
    </a>
</div>

{{-- BUSCADOR --}}
<div class="card card-admin p-3 mb-4">
    <form method="GET" action="{{ route('admin.alumnos.index') }}" class="row g-2 align-items-end">
        <div class="col-md-10">
            <label class="form-label small text-muted mb-1">Buscar</label>
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                <input type="text" name="buscar" value="{{ request('buscar') }}"
                       class="form-control border-start-0"
                       placeholder="Código, nombre, apellido o curso...">
            </div>
        </div>
        <div class="col-md-2 d-flex gap-2">
            <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-funnel"></i> Filtrar
            </button>
            @if(request('buscar'))
                <a href="{{ route('admin.alumnos.index') }}" class="btn btn-outline-secondary" title="Limpiar">
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
                    <th class="ps-4">Código</th>
                    <th>Nombre completo</th>
                    <th class="text-center">Edad</th>
                    <th>Curso</th>
                    <th class="text-end pe-4">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($alumnos as $alumno)
                <tr>
                    <td class="ps-4 fw-semibold">{{ $alumno->codigo }}</td>
                    <td>{{ $alumno->nombre }} {{ $alumno->apellido }}</td>
                    <td class="text-center">{{ $alumno->edad }}</td>
                    <td>
                        <span class="badge bg-light text-dark">{{ $alumno->curso }}</span>
                    </td>
                    <td class="text-end pe-4">
                        <a href="{{ route('admin.alumnos.edit', $alumno->id) }}"
                           class="btn btn-sm btn-outline-primary" title="Editar">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('admin.alumnos.destroy', $alumno->id) }}"
                              method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                    onclick="return confirm('¿Eliminar este alumno?')"
                                    title="Eliminar">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-5 text-muted">
                        <i class="bi bi-people fs-1 d-block mb-2"></i>
                        No se encontraron alumnos
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $alumnos->links() }}
</div>

@endsection