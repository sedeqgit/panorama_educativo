<!DOCTYPE html>
<html lang="{{ str_replace("_", "-", app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(["resources/css/app.css", "resources/js/app.js"])
    <title>Error 500 - Página no encontrada</title>
</head>
<body>
    <div class="row vh-100 align-items-center justify-content-center">
         <div class="row">
            <div class="col-12 text-center">
                <img src={{ asset("images/logo.png") }} style="height:100px; margin: 25px;">
                <h1>Error 500</h1>
                <p>Error interno en el servidor.</p>
                <p>Será redirigido al inicio en <span id="counter">5</span> segundos.</p>
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
            window.location.href="{{ route("welcome-page") }}";
        }
    }, 1000);
</script>
</html>