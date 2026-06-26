@extends('layouts.publica')

@section('title', 'Galería — Academia Triunfadores')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/galeria.css') }}">
@endsection

@section('content')

<main class="my-5 pt-3">
    <h2 class="text-center fw-bold mb-4">NUESTRA GALERÍA</h2>

    <section>
        <img src="{{ asset('fotos/img00.jpg') }}" alt="" class="img-galeria">
        <img src="{{ asset('fotos/img01.jpg') }}" alt="" class="img-galeria">
        <img src="{{ asset('fotos/img02.jpg') }}" alt="" class="img-galeria">
        <img src="{{ asset('fotos/img03.jpg') }}" alt="" class="img-galeria">
        <img src="{{ asset('fotos/img04.jpg') }}" alt="" class="img-galeria">
        <img src="{{ asset('fotos/img05.jpg') }}" alt="" class="img-galeria">
        <img src="{{ asset('fotos/img06.jpg') }}" alt="" class="img-galeria">
        <img src="{{ asset('fotos/img07.jpg') }}" alt="" class="img-galeria">
    </section>
</main>

@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script>
$(".img-galeria").click(function(a) {
    let img = a.target.src;
    let modelo = '<div class="modelo"><img src="' + img + '" alt="" class="img-modelo"><div class="cerrar">X</div></div>';
    $("body").append(modelo);

    $(".cerrar").click(function() {
        $(".modelo").remove();
    });

    $("body").keyup(function(e) {
        if (e.which == 27) {
            $(".modelo").remove();
        }
    });
});
</script>
@endsection