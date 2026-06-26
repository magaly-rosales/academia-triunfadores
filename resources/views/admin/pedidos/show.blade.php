@extends('layouts.admin')

@section('title', "Pedido #{$pedido->id}")

@section('content')

<div class="page-header">
    <div>
        <h4>Pedido #{{ $pedido->id }}</h4>
        <p>Detalle completo del pedido</p>
    </div>
    <a href="{{ route('admin.pedidos.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Volver
    </a>
</div>

<div class="row g-4">
    {{-- INFO PRINCIPAL --}}
    <div class="col-lg-8">
        <div class="card card-admin">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3">
                    <i class="bi bi-bag-check text-primary"></i> Productos / Cursos
                </h6>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Ítem</th>
                                <th>Tipo</th>
                                <th class="text-center">Cantidad</th>
                                <th class="text-end">Precio</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pedido->detalles as $detalle)
                            <tr>
                                <td>{{ $detalle->nombre_item }}</td>
                                <td>
                                    <span class="badge {{ $detalle->item_type === 'curso' ? 'bg-primary' : 'bg-success' }}">
                                        {{ ucfirst($detalle->item_type) }}
                                    </span>
                                </td>
                                <td class="text-center">{{ $detalle->cantidad }}</td>
                                <td class="text-end">S/ {{ number_format($detalle->precio_unitario, 2) }}</td>
                                <td class="text-end fw-semibold">S/ {{ number_format($detalle->subtotal, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-end fw-bold fs-5">Total:</td>
                                <td class="text-end fw-bold fs-5 text-primary">S/ {{ number_format($pedido->total, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- SIDEBAR INFO --}}
    <div class="col-lg-4">
        {{-- Estado --}}
        <div class="card card-admin mb-3">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3"><i class="bi bi-info-circle text-primary"></i> Estado del pedido</h6>
                @if($pedido->estado === 'pendiente')
                    <span class="badge bg-warning text-dark fs-6 p-2"><i class="bi bi-clock"></i> Pendiente de pago</span>
                    <p class="small text-muted mt-3 mb-0">El cliente aún no ha completado el pago en PayPal.</p>
                @elseif($pedido->estado === 'pagado')
                    <span class="badge bg-success fs-6 p-2"><i class="bi bi-check-circle"></i> Pagado</span>
                    <p class="small text-muted mt-3 mb-0">Pago confirmado por PayPal.</p>
                @elseif($pedido->estado === 'cancelado')
                    <span class="badge bg-danger fs-6 p-2"><i class="bi bi-x-circle"></i> Cancelado</span>
                    <p class="small text-muted mt-3 mb-0">El pedido fue cancelado y el stock devuelto.</p>
                @endif
            </div>
        </div>

        {{-- Cliente --}}
        <div class="card card-admin mb-3">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3"><i class="bi bi-person text-primary"></i> Cliente</h6>
                <p class="mb-1 fw-semibold">{{ $pedido->user->name ?? 'Usuario eliminado' }}</p>
                <p class="small text-muted mb-0">{{ $pedido->user->email ?? '-' }}</p>
            </div>
        </div>

        {{-- Pago --}}
        <div class="card card-admin">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3"><i class="bi bi-credit-card text-primary"></i> Información de pago</h6>
                <p class="mb-2">
                    <span class="small text-muted">Método:</span><br>
                    @if($pedido->metodo_pago === 'paypal')
                        <span class="badge" style="background:#0070ba;"><i class="bi bi-paypal"></i> PayPal</span>
                    @else
                        <span class="badge bg-secondary">{{ ucfirst($pedido->metodo_pago) }}</span>
                    @endif
                </p>
                @if($pedido->transaction_id)
                    <p class="mb-2">
                        <span class="small text-muted">ID de transacción:</span><br>
                        <code class="small">{{ $pedido->transaction_id }}</code>
                    </p>
                @endif
                <p class="mb-0">
                    <span class="small text-muted">Fecha del pedido:</span><br>
                    {{ $pedido->created_at->format('d/m/Y H:i') }}
                </p>
            </div>
        </div>
    </div>
</div>

@endsection