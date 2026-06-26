@extends('layouts.admin')

@section('title', 'Pedidos')

@section('content')

<div class="page-header">
    <div>
        <h4>Gestión de Pedidos</h4>
        <p>Todos los pedidos registrados en la plataforma</p>
    </div>
</div>

{{-- ESTADÍSTICAS RÁPIDAS --}}
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card card-admin p-3">
            <div class="d-flex align-items-center gap-3">
                <i class="bi bi-cart-fill text-secondary fs-3"></i>
                <div>
                    <p class="text-muted small mb-0">Total pedidos</p>
                    <h5 class="fw-bold mb-0">{{ $stats['total'] }}</h5>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-admin p-3">
            <div class="d-flex align-items-center gap-3">
                <i class="bi bi-clock-fill text-warning fs-3"></i>
                <div>
                    <p class="text-muted small mb-0">Pendientes</p>
                    <h5 class="fw-bold mb-0">{{ $stats['pendientes'] }}</h5>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-admin p-3">
            <div class="d-flex align-items-center gap-3">
                <i class="bi bi-check-circle-fill text-success fs-3"></i>
                <div>
                    <p class="text-muted small mb-0">Pagados</p>
                    <h5 class="fw-bold mb-0">{{ $stats['pagados'] }}</h5>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-admin p-3">
            <div class="d-flex align-items-center gap-3">
                <i class="bi bi-cash-stack text-primary fs-3"></i>
                <div>
                    <p class="text-muted small mb-0">Ingresos confirmados</p>
                    <h5 class="fw-bold mb-0">S/ {{ number_format($stats['ingresos'], 2) }}</h5>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- BUSCADOR Y FILTROS --}}
<div class="card card-admin p-3 mb-4">
    <form method="GET" action="{{ route('admin.pedidos.index') }}" class="row g-2 align-items-end">
        <div class="col-md-6">
            <label class="form-label small text-muted mb-1">Buscar</label>
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                <input type="text" name="buscar" value="{{ request('buscar') }}"
                       class="form-control border-start-0"
                       placeholder="N° pedido, nombre o email del cliente...">
            </div>
        </div>
        <div class="col-md-4">
            <label class="form-label small text-muted mb-1">Filtrar por estado</label>
            <select name="estado" class="form-select">
                <option value="">Todos los estados</option>
                <option value="pendiente" {{ request('estado') === 'pendiente' ? 'selected' : '' }}>Pendientes</option>
                <option value="pagado"    {{ request('estado') === 'pagado'    ? 'selected' : '' }}>Pagados</option>
                <option value="cancelado" {{ request('estado') === 'cancelado' ? 'selected' : '' }}>Cancelados</option>
            </select>
        </div>
        <div class="col-md-2 d-flex gap-2">
            <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-funnel"></i> Filtrar
            </button>
            @if(request('buscar') || request('estado'))
                <a href="{{ route('admin.pedidos.index') }}" class="btn btn-outline-secondary" title="Limpiar">
                    <i class="bi bi-x-lg"></i>
                </a>
            @endif
        </div>
    </form>
</div>

{{-- TABLA DE PEDIDOS --}}
<div class="card card-admin">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4">#</th>
                    <th>Cliente</th>
                    <th>Fecha</th>
                    <th>Método</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th class="text-end pe-4">Acción</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pedidos as $pedido)
                <tr>
                    <td class="ps-4 fw-semibold">#{{ $pedido->id }}</td>
                    <td>
                        <div class="fw-semibold">{{ $pedido->user->name ?? 'Usuario eliminado' }}</div>
                        <div class="small text-muted">{{ $pedido->user->email ?? '-' }}</div>
                    </td>
                    <td class="small text-muted">{{ $pedido->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        @if($pedido->metodo_pago === 'paypal')
                            <span class="badge" style="background:#0070ba;"><i class="bi bi-paypal"></i> PayPal</span>
                        @else
                            <span class="badge bg-secondary">{{ ucfirst($pedido->metodo_pago) }}</span>
                        @endif
                    </td>
                    <td class="fw-bold">S/ {{ number_format($pedido->total, 2) }}</td>
                    <td>
                        @if($pedido->estado === 'pendiente')
                            <span class="badge bg-warning text-dark"><i class="bi bi-clock"></i> Pendiente</span>
                        @elseif($pedido->estado === 'pagado')
                            <span class="badge bg-success"><i class="bi bi-check-circle"></i> Pagado</span>
                        @elseif($pedido->estado === 'cancelado')
                            <span class="badge bg-danger"><i class="bi bi-x-circle"></i> Cancelado</span>
                        @endif
                    </td>
                    <td class="text-end pe-4">
                        <a href="{{ route('admin.pedidos.show', $pedido->id) }}"
                           class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-eye"></i> Ver
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                        No se encontraron pedidos
                        @if(request('buscar') || request('estado'))
                            con esos filtros
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $pedidos->links() }}
</div>

@endsection