@extends('layouts.publica')

@section('title', 'Academia Triunfadores')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/flexsliderpersonal.css') }}" type="text/css">
<style>
    .flexslider { margin-top: 0 !important; }
</style>
@endsection

@section('content')

{{-- FLEXSLIDER --}}
<div class="flexslider">
    <ul class="slides">
        <li><img src="{{ asset('img/banner1.png') }}"></li>
        <li><img src="{{ asset('img/banner2.png') }}"></li>
        <li><img src="{{ asset('img/banner3.png') }}"></li>
    </ul>
</div>

{{-- NUESTRA EMPRESA --}}
<header class="my-5">
    <div class="container">
        <h2 class="text-center fw-bold mb-4">NUESTRA EMPRESA</h2>
        <p class="text-muted text-center">
            Lorem, ipsum dolor sit amet consectetur adipisicing elit...
        </p>
        <img src="{{ asset('img/img00.png') }}"
             class="d-block m-auto"
             style="max-width:100%; width:450px;">
    </div>
</header>

{{-- APRENDE CON NOSOTROS --}}
<main>
    <div class="container mb-5">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h2 class="fw-bold">Aprende con Nosotros</h2>
                <p class="text-muted">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit...
                </p>
                <a href="/cursos" class="btn btn-primary me-2">Ver Cursos</a>
                <a href="/tienda" class="btn btn-outline-primary">Ver Tienda</a>
            </div>
            <div class="col-lg-6">
                <img src="{{ asset('img/img01.png') }}" class="w-100">
            </div>
        </div>
    </div>
</main>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.0/dist/jquery.min.js"></script>
<script>
    $("body, html").hide().fadeIn(1500);
</script>
<script src="{{ asset('js/jquery.flexslider.js') }}"></script>
<script>
    $(window).on('load', function() {
        $('.flexslider').flexslider({
            pauseOnAction: true,
            pauseOnHover: false,
            touch: true,
            slideshowSpeed: 5000
        });
    });
</script>
@endsection