@extends('layouts.publica')

@section('title', 'Mi Carrito')

@section('content')
<div class="container py-5">
    <h2 class="fw-bold mb-4">🛒 Mi Carrito</h2>

    {{-- Mensajes de éxito/error --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(empty($carrito))
    {{-- Carrito vacío --}}
    <div class="text-center py-5">
        <i class="bi bi-cart-x" style="font-size:4rem; color:#ccc;"></i>
        <p class="mt-3 text-muted fs-5">Tu carrito está vacío.</p>
        <a href="{{ route('cursos.catalogo') }}" class="btn btn-primary me-2">Ver Cursos</a>
        <a href="{{ route('tienda.index') }}" class="btn btn-outline-primary">Ver Tienda</a>
    </div>
    @else
    <div class="row g-4">
        {{-- Lista de ítems --}}
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-body p-0">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Producto</th>
                                <th class="text-center">Cantidad</th>
                                <th class="text-end">Precio</th>
                                <th class="text-end">Subtotal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($carrito as $key => $item)
                            <tr data-key="{{ $key }}">
                                <td class="ps-4">
                                    <div class="d-flex align-items-center gap-3">
                                        @if($item['imagen'])
                                        <img src="{{ asset('storage/' . $item['imagen']) }}"
                                            style="width:60px;height:60px;object-fit:cover;border-radius:8px;">
                                        @else
                                        <div style="width:60px;height:60px;background:#f0f0f0;border-radius:8px;display:flex;align-items:center;justify-content:center;">
                                            <i class="bi bi-image text-muted"></i>
                                        </div>
                                        @endif
                                        <div>
                                            <p class="mb-0 fw-semibold">{{ $item['nombre'] }}</p>
                                            <span class="badge {{ $item['tipo'] === 'curso' ? 'bg-primary' : 'bg-success' }} text-uppercase small">
                                                {{ $item['tipo'] }}
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center" style="width:160px;">
                                    <div class="d-flex justify-content-center align-items-center gap-1">
                                        <button type="button" class="btn btn-sm btn-outline-secondary btn-menos" data-key="{{ $key }}">−</button>
                                        <input type="number"
                                            value="{{ $item['cantidad'] }}"
                                            min="1"
                                            class="form-control form-control-sm text-center input-cantidad"
                                            data-key="{{ $key }}"
                                            data-precio="{{ $item['precio'] }}"
                                            style="width:55px;">
                                        <button type="button" class="btn btn-sm btn-outline-secondary btn-mas" data-key="{{ $key }}">+</button>
                                    </div>
                                </td>
                                <td class="text-end">S/ {{ number_format($item['precio'], 2) }}</td>
                                <td class="text-end fw-semibold subtotal-item" data-key="{{ $key }}">
                                    S/ {{ number_format($item['precio'] * $item['cantidad'], 2) }}
                                </td>
                                <td class="text-end pe-4">
                                    <form action="{{ route('carrito.quitar', $key) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('¿Quitar este ítem?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Vaciar carrito --}}
            <form action="{{ route('carrito.vaciar') }}" method="POST" class="mt-3">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-sm"
                    onclick="return confirm('¿Vaciar todo el carrito?')">
                    <i class="bi bi-trash3"></i> Vaciar carrito
                </button>
            </form>
        </div>

        {{-- Resumen del pedido --}}
        <div class="col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="fw-bold mb-4">Resumen del pedido</h5>

                    <div class="d-flex justify-content-between mb-2 text-muted">
                        <span>Subtotal (<span id="resumen-items">{{ array_sum(array_column($carrito, 'cantidad')) }}</span> ítems)</span>
                        <span>S/ <span id="resumen-subtotal">{{ number_format($total, 2) }}</span></span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between fw-bold fs-5 mb-4">
                        <span>Total</span>
                        <span class="text-primary">S/ <span id="resumen-total">{{ number_format($total, 2) }}</span></span>
                    </div>

                    @auth
                    <form action="{{ route('carrito.confirmar') }}" method="POST">
                        @csrf
                        <input type="hidden" name="metodo_pago" value="paypal">
                        <button type="submit" class="btn w-100 py-2 fw-semibold text-white"
                            style="background:#0070ba;">
                            <i class="bi bi-paypal"></i> Pagar con PayPal
                        </button>
                    </form>
                    <p class="text-center text-muted small mt-2">
                        <i class="bi bi-shield-check"></i> Pago 100% seguro vía PayPal
                    </p>
                    @else
                    {{-- No logueado: pide login --}}
                    <a href="{{ route('login') }}?redirect=carrito"
                        class="btn btn-primary w-100 py-2 fw-semibold">
                        <i class="bi bi-box-arrow-in-right"></i> Iniciar sesión para confirmar
                    </a>
                    <p class="text-center text-muted small mt-2">
                        ¿No tienes cuenta?
                        <a href="{{ route('register') }}">Regístrate gratis</a>
                    </p>
                    @endauth
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    const CSRF = '{{ csrf_token() }}';

    // ─── Botón + ───────────────────────────────────────────────────
    document.querySelectorAll('.btn-mas').forEach(btn => {
        btn.addEventListener('click', () => {
            const input = document.querySelector(`.input-cantidad[data-key="${btn.dataset.key}"]`);
            input.value = parseInt(input.value) + 1;
            actualizarCantidad(btn.dataset.key, input.value);
        });
    });

    // ─── Botón − ───────────────────────────────────────────────────
    document.querySelectorAll('.btn-menos').forEach(btn => {
        btn.addEventListener('click', () => {
            const input = document.querySelector(`.input-cantidad[data-key="${btn.dataset.key}"]`);
            const nueva = parseInt(input.value) - 1;
            if (nueva >= 1) {
                input.value = nueva;
                actualizarCantidad(btn.dataset.key, input.value);
            }
        });
    });

    // ─── Si el usuario escribe directo en el input ─────────────────
    document.querySelectorAll('.input-cantidad').forEach(input => {
        input.addEventListener('change', () => {
            if (parseInt(input.value) >= 1) {
                actualizarCantidad(input.dataset.key, input.value);
            } else {
                input.value = 1;
            }
        });
    });

    // ─── Función AJAX que llama al backend ─────────────────────────
    async function actualizarCantidad(key, cantidad) {
        try {
            const res = await fetch(`/carrito/actualizar/${key}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': CSRF,
                    'X-HTTP-Method-Override': 'PATCH'
                },
                body: JSON.stringify({
                    cantidad: parseInt(cantidad),
                    _method: 'PATCH'
                })
            });

            const data = await res.json();

            if (!data.ok) {
                alert(data.message || 'Error al actualizar.');
                if (data.stock_max) {
                    document.querySelector(`.input-cantidad[data-key="${key}"]`).value = data.stock_max;
                }
                return;
            }

            // Actualizar subtotal del ítem
            document.querySelector(`.subtotal-item[data-key="${key}"]`).textContent = `S/ ${data.subtotal}`;

            // Actualizar resumen lateral
            document.getElementById('resumen-subtotal').textContent = data.total;
            document.getElementById('resumen-total').textContent = data.total;
            document.getElementById('resumen-items').textContent = data.total_items;

            // Actualizar contador del navbar (si existe el badge)
            const badge = document.querySelector('.carrito-badge');
            if (badge) badge.textContent = data.total_items;

        } catch (err) {
            console.error(err);
            alert('Error de conexión.');
        }
    }
</script>
@endsection