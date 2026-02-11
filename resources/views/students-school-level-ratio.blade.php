@extends('layouts.app')

@vite(['resources/css/tables.css','resources/js/charts.js','resources/css/charts.css'])

@php
    $route=request()->route()->uri();
    $period=implode('/',array_slice(explode('/',$route),0,1));
@endphp

@section('title', 'Proporción de alumnos atendidos por tipo o nivel educativo ('.$period.')')

@section('content')
    <center>
        <h2>Proporción de alumnos atendidos por tipo o nivel educativo ({{ $period }})</h2>
    </center>
    <div class="container text-center">
        <div class="mx-5 px-5">
            * Incluye alumnos de modalidades Escolarizado, No Escolarizado y Mixto
            <br>
            ** Incluye TSU, Licenciatura y Posgrado
        </div>
        <div class="mt-2"><!--boton de descarga de grafica-->
            <button id="descargarGraficaBtn" class="btn boton-descarga">Descargar gráfica</button>
        </div>
        <canvas id="students_school_level_ratio" class="pie-chart m-auto mt-2"></canvas>
    </div>
    <script type="module">
        let labels=[]
        let data=[]

        @foreach ($statistics as $level=>$data)
            @if ( $level != "Especial (USAER)")
                @switch($level)
                    @case("Media Superior")
                        labels.push("{{ $level }} *");
                        @break
                    @case("Superior")
                        labels.push("{{ $level }} */**");
                        @break
                    @default
                        labels.push("{{ $level }}");
                @endswitch
                data.push({{ $data['male_students'] + $data['female_students'] }});
            @endif
        @endforeach

        let datasets=[]
        
        let schools_school_level_sustenance={
            labels: labels,
            datasets: [{
                data: data
            }]
        }

        const myChart = new Chart("students_school_level_ratio", {
            type: "pie",
            data: schools_school_level_sustenance,
            options: {
                radius: '60%',
                responsive: true,
                plugins: {
                    datalabels: {
                        anchor: "end",
                        align: "top",
                    },
                    legend: {
                        onClick: null
                    }
                }
            }
        });

        document.getElementById('descargarGraficaBtn').addEventListener('click', function () {
            const enlace = document.createElement('a');
            enlace.href = myChart.toBase64Image(); // Convierte el canvas a imagen
            enlace.download = `Proporcion-de-alumnos-atendidos-por-tipo-o-nivel-educativo-{{$period}}.png`; // Nombre del archivo
            enlace.click();
        });
    </script>
@include('layouts.footer')
@endsection