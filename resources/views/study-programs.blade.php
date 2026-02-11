@extends('layouts.app')

@vite(['resources/css/tables.css','resources/js/charts.js','resources/css/charts.css'])

@php
    $sum=0;
    foreach($statistics as $type=>$data){
        $sum+=$data['carriers'];
    }
    $route=request()->route()->uri();
    $period=implode('/',array_slice(explode('/',$route),0,1));
@endphp

@section('title', $title.' ('.$period.')')

@section(section: 'content')
    <center>
        <h2>{{ $title }} ({{ $period }})</h2>
        <p>Total de carreras: {{ number_format($sum) }}</p>
    </center>
    <center class="mt-2"><!--boton de descarga de grafica-->
            <button id="descargarGraficaBtn" class="btn boton-descarga">Descargar gráfica</button>
    </center>
    <div>
        <canvas id="study_programs" class="pie-chart m-auto"></canvas>
    </div>
    
    <script type="module">
        let labels=[]
        let data=[]

        @foreach ($statistics as $type=>$data)
            labels.push("{{ $type }}");
            data.push({{ $data['carriers'] }});
        @endforeach

        let datasets=[]
        
        let study_programs={
            labels: labels,
            datasets: [{
                data: data
            }]
        }

        const myChart = new Chart("study_programs", {
            type: "pie",
            data: study_programs,
            
            options: {
                radius: '75%',
                responsive: true,
                maintainAspectRatio: false,
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