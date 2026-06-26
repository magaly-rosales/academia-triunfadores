@extends('layouts.publica')

@section('title', 'Contactos — Academia Triunfadores')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/galeria.css') }}">
@endsection

@section('content')

{{-- MAPA --}}
<div class="mt-2">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3901.9639920223663!2d-77.03515923008075!3d-12.045998515760749!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9105c8b5d5aa7eb1%3A0x16061e0b481e22aa!2sPlaza%20Mayor%20de%20Lima!5e0!3m2!1ses-419!2spe!4v1690189025738!5m2!1ses-419!2spe"
            width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
</div>

{{-- FORMULARIO DE CONTACTO --}}
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <h4 class="fw-bold mb-4 text-center">Contáctanos</h4>
                    <form action="{{ url('/envio') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Apellidos y Nombres</label>
                            <input type="text" class="form-control" placeholder="Ingresa tus nombres" name="nombres">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Dirección</label>
                            <input type="text" class="form-control" placeholder="Ingresa tu dirección" name="direction">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Correo</label>
                            <input type="email" class="form-control" placeholder="Ingresa tu correo" name="correo">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Comentarios</label>
                            <textarea name="comentarios" class="form-control" rows="4"></textarea>
                        </div>
                        <button class="btn btn-dark w-100">Enviar mensaje</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection