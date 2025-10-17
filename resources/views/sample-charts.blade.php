<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @vite(['resources/js/chart.js'])
        @vite(['resources/js/sample-charts-generator.js'])
    </head>
    <body>
        <h1>Panorama educativo estatal ciclo 2024-2025</h1>
        <div style="padding: 20px">
            <canvas id="ProporcionAlumnosTipoNivelEducativo" width="300" height="150"></canvas>
        </div>
        <div style="padding: 20px">
            <canvas id="DocentesTipoNivelEducativo" width="300" height="150"></canvas>
        </div>
        <div style="padding: 20px">
            <canvas id="MatriculaHistoricaMediaSuperior" width="300" height="150"></canvas>
        </div>
    </body>
</html>