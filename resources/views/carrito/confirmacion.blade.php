@extends('layouts.publica')

@section('title', 'Pedido Confirmado')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <i class="bi bi-check-circle-fill text-success" style="font-size:4rem;"></i>
        <h2 class="fw-bold mt-3">¡Pedido confirmado!</h2>
        <p class="text-muted">Número de pedido: <strong>#{{ $pedido->id }}</strong></p>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="fw-bold mb-4">Detalle del pedido</h5>
                    <table class="table">
                        <thead class="table-light">
                            <tr>
                                <th>Ítem</th>
                                <th class="text-center">Cant.</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pedido->detalles as $detalle)
                            <tr>
                                <td>
                                    {{ $detalle->nombre_item }}
                                    <span class="badge {{ $detalle->item_type === 'curso' ? 'bg-primary' : 'bg-success' }} ms-1">
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
                                <td colspan="2" class="text-end">Total:</td>
                                <td class="text-end text-primary">S/ {{ number_format($pedido->total, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>

                    <div class="alert alert-info mt-3">
                        <i class="bi bi-info-circle"></i>
                        Tu pedido está <strong>pendiente</strong>. Nuestro equipo lo procesará pronto.
                    </div>

                    <div class="d-flex gap-2 justify-content-center mt-4">
                        <a href="{{ route('pedidos.mis') }}" class="btn btn-outline-primary">Ver mis pedidos</a>
                        <a href="{{ route('cursos.catalogo') }}" class="btn btn-primary">Seguir comprando</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
