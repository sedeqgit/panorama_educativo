<!DOCTYPE html>
<html lang="{{ str_replace("_", "-", app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(["resources/css/app.css", "resources/js/app.js"])
    <title>Error 500 - Página no encontrada</title>
    <style> body { background-color: #f0f2f5; } </style>
</head>
<body>
    <div class="container d-flex vh-100">
        <div class="row align-items-center justify-content-center w-100">
            <div class="col-12 col-md-8 text-center">
                <img src="{{ asset("images/logo.png") }}" alt="Logo del sitio" class="error-page-logo" style="height:100px; margin: 25px;">
                <h1 class="display-1 fw-bold">500</h1>
                <h2>Error interno del servidor</h2>
                <p class="lead">Lo sentimos, ha ocurrido un error interno en el servidor.</p>
                <p>Serás redirigido al inicio en <span id="counter" aria-live="polite">5</span> segundos.</p>
                <a href="{{ route("welcome-page") }}" class="btn btn-primary mt-3">Volver al inicio</a>
            </div>
        </div>
    </div>
</body>
<script>
    let counter=5;
    const el=document.getElementById("counter");
    const interval=setInterval(()=>{
        counter--;
        el.textContent=counter;
        if (counter<=0){
            clearInterval(interval);
             window.location.href = "{{ url('/') }}";
        }
    }, 1000);
</script>
</html>