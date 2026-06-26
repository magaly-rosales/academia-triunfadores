@extends('layouts.publica')

@section('title', 'Nosotros — Academia Triunfadores')

@section('content')

{{-- CAROUSEL --}}
<div id="carouselExampleCaptions" class="carousel slide">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"></button>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"></button>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"></button>
    </div>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="{{ asset('img/banner4.png') }}" class="d-block w-100" alt="">
        </div>
        <div class="carousel-item">
            <img src="{{ asset('img/banner3.png') }}" class="d-block w-100" alt="">
        </div>
        <div class="carousel-item">
            <img src="{{ asset('img/banner2.png') }}" class="d-block w-100" alt="">
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
</div>

{{-- NOSOTROS --}}
<header class="my-5">
    <div class="container">
        <h2 class="text-center fw-bold mb-4">NOSOTROS</h2>
        <p class="text-muted">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Ipsum explicabo obcaecati praesentium. Vel possimus dignissimos neque explicabo maiores omnis aut quos ut provident? Corrupti corporis aspernatur quisquam consequuntur repellendus dolor.</p>
        <img src="{{ asset('img/img01.png') }}" width="450px" class="d-block m-auto" style="max-width:100%;">
    </div>
</header>

{{-- ACCORDION --}}
<main class="my-5">
    <div class="container">
        <div class="accordion accordion-flush" id="accordionFlushExample">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed bg-danger text-white" type="button"
                            data-bs-toggle="collapse" data-bs-target="#flush-collapseOne">
                        ¿De donde obtenemos los materiales para las clases?
                    </button>
                </h2>
                <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">Placeholder content para este acordeón.</div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed bg-primary text-white" type="button"
                            data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo">
                        ¿Cuál es el mejor curso de tu preferencia?
                    </button>
                </h2>
                <div id="flush-collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">Placeholder content para este acordeón.</div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed bg-warning text-dark" type="button"
                            data-bs-toggle="collapse" data-bs-target="#flush-collapseThree">
                        ¿Qué nos diferencia de otras academias?
                    </button>
                </h2>
                <div id="flush-collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">Placeholder content para este acordeón.</div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection