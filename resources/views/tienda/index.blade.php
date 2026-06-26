@extends('layouts.publica')

@section('title', 'Tienda')

@section('content')
<div class="container py-5">
    <h2 class="fw-bold mb-1">Tienda</h2>
    <p class="text-muted mb-4">Materiales, libros y más</p>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        {{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if($productos->isEmpty())
    <p class="text-muted">No hay productos disponibles por el momento.</p>
    @else
    <div class="row g-4">
        @foreach($productos as $producto)
        <div class="col-md-6 col-lg-3">
            <div class="card h-100 shadow-sm border-0 rounded-4">
                @if($producto->imagen)
                <img src="{{ asset('storage/' . $producto->imagen) }}"
                    class="card-img-top rounded-top-4"
                    style="height:180px;object-fit:cover;">
                @else
                <div class="card-img-top rounded-top-4 d-flex align-items-center justify-content-center bg-light"
                    style="height:180px;">
                    <i class="bi bi-box-seam text-secondary" style="font-size:2.5rem;"></i>
                </div>
                @endif

                <div class="card-body d-flex flex-column">
                    @if($producto->categoria)
                    <span class="badge bg-success-subtle text-success mb-2 w-fit">{{ $producto->categoria }}</span>
                    @endif

                    <h6 class="card-title fw-bold">{{ $producto->nombre }}</h6>
                    <p class="card-text text-muted small flex-grow-1">
                        {{ Str::limit($producto->descripcion, 80) }}
                    </p>

                    <div class="mt-auto pt-3 border-top">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fs-6 fw-bold text-success">S/ {{ number_format($producto->precio, 2) }}</span>
                            <span class="small text-muted">
                                @if($producto->stock > 0)
                                <i class="bi bi-check-circle text-success"></i> En stock ({{ $producto->stock }})
                                @else
                                <i class="bi bi-x-circle text-danger"></i> Sin stock
                                @endif
                            </span>
                        </div>

                        @if($producto->stock > 0)
                        @auth
                        {{-- Logueado: agrega directo al carrito --}}
                        <form action="{{ route('carrito.agregar') }}" method="POST">
                            @csrf
                            <input type="hidden" name="item_type" value="producto">
                            <input type="hidden" name="item_id" value="{{ $producto->id }}">
                            <button type="submit" class="btn btn-sm btn-success w-100">
                                <i class="bi bi-cart-plus"></i> Agregar al carrito
                            </button>
                        </form>
                        @else
                        {{-- Invitado: guarda intención y va al login --}}
                        <a href="{{ url('/login') }}?intent=producto_{{ $producto->id }}"
                            class="btn btn-sm btn-success w-100"
                            {{ $modoApp ? 'target="_system"' : '' }}>
                            <i class="bi bi-cart-plus"></i> Agregar al carrito
                        </a>
                        @endauth
                        @else
                        <button class="btn btn-sm btn-secondary w-100" disabled>Sin stock</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-4">{{ $productos->links() }}</div>
    @endif
</div>
@endsection