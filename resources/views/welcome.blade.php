@extends('layouts.app')

@section('title', 'Panorama educativo')

@section(section: 'content')
    <!--<h1>Bienvenido al sitio de estadísticas de la SEDEQ</h1>-->
    
    <div class="container py-5">
    
    <div class="row justify-content-center text-center">
        <div class="col-md-10">
            <h1 class="sedeq-title">Bienvenido al Sistema de Estadística</h1>
            <p class="sedeq-subtitle">Secretaría de Educación del Estado de Querétaro</p>
            <hr class="w-25 mx-auto mb-5" style="border-top: 3px solid #266fb6; opacity: 1;">
        </div>
    </div>

    <div class="row g-4">
        <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner" >
                <div class="carousel-item active">
                <img src="{{ asset("images/1000027331c.JPG") }}" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                <img src="{{ asset("images/1000027333.jpg") }}" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                <img src="{{ asset("images/1000027334.jpg") }}" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                <img src="{{ asset("images/1000027335.jpg") }}" class="d-block w-100" alt="...">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev" >
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-12 text-center">
            <div class="alert alert-light border" role="alert" style="font-size: 0.9rem;">
                <strong>Nota:</strong><!-- La información presentada en este portal es de carácter público y oficial.-->
            </div>
        </div>
    </div>
    
    
</div>
@include('layouts.footer')
@endsection