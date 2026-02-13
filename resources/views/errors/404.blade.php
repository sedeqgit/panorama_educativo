<!DOCTYPE html>
<html lang="{{ str_replace("_", "-", app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(["resources/css/app.css", "resources/js/app.js"])
    <title>Error 404 - Página no encontrada</title>
</head>
<body>
    <div class="container d-flex vh-100">
        <div class="row align-items-center justify-content-center w-100">
            <div class="col-12 col-md-8 text-center">
                <img src="{{ asset("images/logo.png") }}" alt="Logo del sitio" class="error-page-logo">
                <h1 class="display-1 fw-bold">404</h1>
                <h2>Página no encontrada</h2>
                <p class="lead">Lo sentimos, la página que buscas no existe o ha sido movida.</p>
                <p>Serás redirigido al inicio en <span id="counter" aria-live="polite">5</span> segundos.</p>
                <a href="{{ url('/') }}" class="btn btn-primary mt-3">Volver al inicio</a>
            </div>
        </div>
    </div>
</body>
<script>
    (function() {
        let counter = 5;
        const counterElement = document.getElementById("counter");

        if (counterElement) {
            const interval = setInterval(() => {
                counter--;
                counterElement.textContent = counter;
                if (counter <= 0) {
                    clearInterval(interval);
                    window.location.href = "{{ url('/') }}";
                }
            }, 1000);
        }
    })();
</script>
</html>