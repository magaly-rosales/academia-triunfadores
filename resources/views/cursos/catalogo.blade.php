@extends('layouts.publica')

@section('title', 'Nuestros Cursos')

@section('content')
<div class="container py-5">
    <h2 class="fw-bold mb-1">Nuestros Cursos</h2>
    <p class="text-muted mb-4">Aprende con los mejores instructores</p>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($cursos->isEmpty())
        <p class="text-muted">No hay cursos disponibles por el momento.</p>
    @else
        <div class="row g-4">
            @foreach($cursos as $curso)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm border-0 rounded-4">
                    {{-- Imagen --}}
                    @if($curso->imagen)
                        <img src="{{ asset('storage/' . $curso->imagen) }}"
                             class="card-img-top rounded-top-4"
                             style="height:200px;object-fit:cover;">
                    @else
                        <div class="card-img-top rounded-top-4 d-flex align-items-center justify-content-center bg-light"
                             style="height:200px;">
                            <i class="bi bi-mortarboard text-secondary" style="font-size:3rem;"></i>
                        </div>
                    @endif

                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span class="badge bg-primary-subtle text-primary">{{ $curso->categoria ?? 'General' }}</span>
                            <span class="badge bg-secondary-subtle text-secondary">{{ $curso->nivel }}</span>
                        </div>

                        <h5 class="card-title fw-bold">{{ $curso->nombre }}</h5>
                        <p class="card-text text-muted small flex-grow-1">
                            {{ Str::limit($curso->descripcion, 100) }}
                        </p>

                        @if($curso->duracion)
                            <p class="text-muted small mb-2">
                                <i class="bi bi-clock"></i> {{ $curso->duracion }}
                            </p>
                        @endif

                        <div class="d-flex align-items-center justify-content-between mt-auto pt-3 border-top">
                            <span class="fs-5 fw-bold text-primary">S/ {{ number_format($curso->precio, 2) }}</span>
                            <div class="d-flex gap-2">
                                <a href="{{ route('cursos.detalle', $curso->id) }}"
                                   class="btn btn-sm btn-outline-secondary">Ver más</a>
                                {{-- Botón agregar al carrito --}}
                                <form action="{{ route('carrito.agregar') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="item_type" value="curso">
                                    <input type="hidden" name="item_id" value="{{ $curso->id }}">
                                    <button type="submit" class="btn btn-sm btn-primary">
                                        <i class="bi bi-cart-plus"></i> Agregar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-4">{{ $cursos->links() }}</div>
    @endif
</div>
@endsection
