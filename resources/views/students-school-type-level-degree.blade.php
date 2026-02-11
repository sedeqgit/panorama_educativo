@extends('layouts.app')

@vite(['resources/css/charts.css'])

@switch($level)
    @case("Media Superior")
        @vite(['resources/js/high-school-charts.js'])
        @break
    @case("Superior")
        @vite(['resources/js/university-charts.js'])
        @break
@endswitch

@php
    $sum=0;
    foreach($statistics as $type=>$data){
        $sum+=$data['male_students'] + $data['female_students'];
    }
    $route=request()->route()->uri();
    $period=implode('/',array_slice(explode('/',$route),0,1));
@endphp

@section('title', $title.' ('.$period.')')

@section(section: 'content')
    <center>
        <h2>{{ $title }} ({{ $period }})</h2>
        <p>Matrícula total: {{ number_format($sum) }}</p>
    </center>
    <div class="container text-center">
        <!--<canvas id="students_high_school_type" class="pie-chart m-auto"></canvas>-->
        <div class="mx-5 px-5">
            * Incluye alumnos de modalidades Escolarizado, No Escolarizado y Mixto
        </div>
        <div class="mt-2"><!--boton de descarga de grafica-->
            <button id="descargarGraficaBtn" class="btn boton-descarga">Descargar gráfica</button>
        </div>
        <canvas id="students_high_school_type" class="pie-chart m-auto mt-2"></canvas>
    </div>
    <script type="module">
        let labels=[]
        let data=[]

        @foreach ($statistics as $type=>$data)
            labels.push("{{ $type }}");
            data.push({{ $data['male_students'] + $data['female_students'] }});
        @endforeach
        
        let students_high_school_type={
            labels: labels,
            datasets: [{
                data: data
            }]
        }

        const myChart = new Chart("students_high_school_type", {
            type: "pie",
            data: students_high_school_type,
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
            enlace.download = `{{ $title }}-{{$period}}.png`; // Nombre del archivo
            enlace.click();
        });
    </script>
    @include('layouts.footer')
@endsection
