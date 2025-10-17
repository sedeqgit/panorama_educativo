@extends('layouts.app')

@section('title', $title)

@vite(['resources/css/tables.css','resources/js/chart.js','resources/css/charts.css'])

@php
    $sum=0;
    foreach($statistics as $type=>$data){
        if($type!="Escuelas") $sum+=$data['male_students'] + $data['female_students'];
    }
@endphp

@section(section: 'content')
    <center>
        <h2>{{ $title }}</h2>
        <p>Total de alumnos: {{ number_format($sum) }}</p>
    </center>
    <canvas id="students_high_school_type" class="pie-chart m-auto"></canvas>
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