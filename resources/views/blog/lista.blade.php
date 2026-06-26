@extends('layouts.publica')

@section('title', 'Blog — Academia Triunfadores')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold">Blog</h2>
        <p class="text-muted">Artículos, consejos y novedades de la academia</p>
    </div>

    @if($posts->isEmpty())
        <div class="text-center py-5">
            <i class="bi bi-journal-x" style="font-size:4rem; color:#ccc;"></i>
            <p class="mt-3 text-muted fs-5">Aún no hay artículos publicados.</p>
        </div>
    @else
        <div class="row g-4">
            @foreach($posts as $post)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-4">
                    {{-- Imagen portada --}}
                    @if($post->imagen)
                        <img src="{{ asset('storage/' . $post->imagen) }}"
                             class="card-img-top rounded-top-4"
                             style="height:200px; object-fit:cover;">
                    @else
                        <div class="rounded-top-4 d-flex align-items-center justify-content-center bg-light"
                             style="height:200px;">
                            <i class="bi bi-journal-text text-secondary" style="font-size:3rem;"></i>
                        </div>
                    @endif

                    <div class="card-body d-flex flex-column">
                        @if($post->categoria)
                            <span class="badge bg-primary-subtle text-primary mb-2 w-fit">
                                {{ $post->categoria }}
                            </span>
                        @endif

                        <h5 class="card-title fw-bold">{{ $post->titulo }}</h5>

                        <p class="card-text text-muted small flex-grow-1">
                            {{ $post->resumen ?? Str::limit(strip_tags($post->contenido), 100) }}
                        </p>

                        <div class="d-flex justify-content-between align-items-center mt-auto pt-3 border-top">
                            <small class="text-muted">
                                <i class="bi bi-calendar3 me-1"></i>
                                {{ $post->publicado_en?->format('d/m/Y') }}
                            </small>
                            <a href="{{ route('blog.detalle', $post->slug) }}"
                               class="btn btn-sm btn-outline-primary">
                                Leer más <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-5">{{ $posts->links() }}</div>
    @endif
</div>
@endsection
