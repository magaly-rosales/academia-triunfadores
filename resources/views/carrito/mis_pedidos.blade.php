@extends('layouts.publica')

@section('title', 'Mis Pedidos')

@section('content')
<div class="container py-5">
    <h4 class="fw-bold mb-1">Mis Pedidos</h4>
    <p class="text-muted mb-4">Historial de todas tus compras</p>

    @if($pedidos->isEmpty())
        <div class="text-center py-5">
            <i class="bi bi-bag-x" style="font-size:4rem; color:#ccc;"></i>
            <p class="mt-3 text-muted fs-5">Aún no tienes pedidos.</p>
            <a href="/cursos" class="btn btn-primary me-2">Ver Cursos</a>
            <a href="/tienda" class="btn btn-outline-primary">Ver Tienda</a>
        </div>
    @else
        <div class="d-flex flex-column gap-4">
            @foreach($pedidos as $pedido)
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    {{-- Cabecera del pedido --}}
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h6 class="fw-bold mb-0">Pedido #{{ $pedido->id }}</h6>
                            <small class="text-muted">{{ $pedido->created_at->format('d/m/Y H:i') }}</small>
                        </div>
                        <div class="text-end">
                            @if($pedido->estado === 'pagado')
                                <span class="badge bg-success-subtle text-success fs-6 px-3 py-2">
                                    <i class="bi bi-check-circle me-1"></i>Pagado
                                </span>
                            @elseif($pedido->estado === 'pendiente')
                                <span class="badge bg-warning-subtle text-warning fs-6 px-3 py-2">
                                    <i class="bi bi-clock me-1"></i>Pendiente
                                </span>
                            @else
                                <span class="badge bg-danger-subtle text-danger fs-6 px-3 py-2">
                                    <i class="bi bi-x-circle me-1"></i>Cancelado
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Detalle de ítems --}}
                    <table class="table table-sm mb-3">
                        <thead class="table-light">
                            <tr>
                                <th>Ítem</th>
                                <th>Tipo</th>
                                <th class="text-center">Cantidad</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pedido->detalles as $detalle)
                            <tr>
                                <td>{{ $detalle->nombre_item }}</td>
                                <td>
                                    <span class="badge {{ $detalle->item_type === 'curso' ? 'bg-primary' : 'bg-success' }}">
                                        {{ $detalle->item_type }}
                                    </span>
                                </td>
                                <td class="text-center">{{ $detalle->cantidad }}</td>
                                <td class="text-end">S/ {{ number_format($detalle->subtotal, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="fw-bold">
                                <td colspan="3" class="text-end">Total:</td>
                                <td class="text-end text-primary">S/ {{ number_format($pedido->total, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>

                    @if($pedido->estado === 'pendiente')
                        <div class="alert alert-info mb-0 py-2 small">
                            <i class="bi bi-info-circle me-1"></i>
                            Tu pedido está siendo procesado. Nos contactaremos contigo pronto.
                        </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-4">{{ $pedidos->links() }}</div>
    @endif
</div>
@endsection