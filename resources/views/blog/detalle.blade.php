@extends('layouts.publica')

@section('title', $post->titulo)

@section('content')
<div class="container py-5">
    <div class="row">
        {{-- CONTENIDO PRINCIPAL --}}
        <div class="col-lg-8">
            {{-- Breadcrumb --}}
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="/blog">Blog</a></li>
                    <li class="breadcrumb-item active">{{ Str::limit($post->titulo, 40) }}</li>
                </ol>
            </nav>

            {{-- Categoría --}}
            @if($post->categoria)
                <span class="badge bg-primary-subtle text-primary mb-3">{{ $post->categoria }}</span>
            @endif

            {{-- Título --}}
            <h1 class="fw-bold mb-3">{{ $post->titulo }}</h1>

            {{-- Meta --}}
            <div class="d-flex align-items-center gap-3 text-muted small mb-4">
                <span><i class="bi bi-person me-1"></i>{{ $post->autor->name }}</span>
                <span><i class="bi bi-calendar3 me-1"></i>{{ $post->publicado_en?->format('d \d\e F \d\e Y') }}</span>
            </div>

            {{-- Imagen portada --}}
            @if($post->imagen)
                <img src="{{ asset('storage/' . $post->imagen) }}"
                     class="img-fluid rounded-4 mb-4 w-100"
                     style="max-height:400px; object-fit:cover;">
            @endif

            {{-- Contenido --}}
            <div class="post-contenido fs-6 lh-lg">
                {!! nl2br(e($post->contenido)) !!}
            </div>

            {{-- Volver --}}
            <div class="mt-5 pt-4 border-top">
                <a href="/blog" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Volver al Blog
                </a>
            </div>
        </div>

        {{-- SIDEBAR --}}
        <div class="col-lg-4">
            <div class="sticky-top" style="top:80px;">

                {{-- Posts recientes --}}
                @if($recientes->isNotEmpty())
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3">Artículos recientes</h6>
                        @foreach($recientes as $reciente)
                        <a href="{{ route('blog.detalle', $reciente->slug) }}"
                           class="d-flex gap-3 mb-3 text-decoration-none text-dark">
                            @if($reciente->imagen)
                                <img src="{{ asset('storage/' . $reciente->imagen) }}"
                                     style="width:60px;height:60px;object-fit:cover;border-radius:8px;flex-shrink:0;">
                            @else
                                <div style="width:60px;height:60px;background:#f0f0f0;border-radius:8px;flex-shrink:0;display:flex;align-items:center;justify-content:center;">
                                    <i class="bi bi-journal text-muted"></i>
                                </div>
                            @endif
                            <div>
                                <p class="mb-0 small fw-semibold lh-sm">{{ Str::limit($reciente->titulo, 55) }}</p>
                                <small class="text-muted">{{ $reciente->publicado_en?->format('d/m/Y') }}</small>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- CTA cursos --}}
                <div class="card border-0 shadow-sm rounded-4 bg-primary text-white">
                    <div class="card-body text-center p-4">
                        <i class="bi bi-mortarboard-fill fs-1 mb-3"></i>
                        <h6 class="fw-bold">¿Listo para aprender?</h6>
                        <p class="small mb-3 opacity-75">Explora nuestros cursos y lleva tus habilidades al siguiente nivel.</p>
                        <a href="/cursos" class="btn btn-light btn-sm fw-semibold">Ver cursos</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
