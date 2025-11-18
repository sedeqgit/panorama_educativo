@extends('layouts.app')

@vite(['resources/css/tables.css','resources/js/chart.js','resources/css/charts.css'])

@php
    $sum=0;
    foreach($statistics as $type=>$data){
        if($type!="Escuelas") $sum+=$data['male_students'] + $data['female_students'];
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
    <div class="position-absolute start-50 translate-middle-x">
        <canvas id="students_high_school_type" class="pie-chart m-auto"></canvas>
        <div class="mx-5 px-5">
            * Incluye alumnos de modalidades Escolarizado, No Escolarizado y Mixto
        </div>
    </div>
    <script type="module">
        let labels=[]
        let data=[]

        @foreach ($statistics as $type=>$data)
            @if ($type!="Escuelas")
                labels.push("{{ $type }}");
                data.push({{ $data['male_students'] + $data['female_students'] }});
            @endif
        @endforeach
        
        let students_high_school_type={
            labels: labels,
            datasets: [{
                data: data
            }]
        }

        new Chart("students_high_school_type", {
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
    </script>
@endsection