@extends('layouts.app')

@section('title', $title)

@vite(['resources/css/tables.css','resources/js/chart.js','resources/css/charts.css'])

@php
    $sum=0;
    foreach($statistics as $type=>$data){
        if($type!="Escuelas") $sum+=$data['carriers'];
    }
@endphp

@section(section: 'content')
    <center>
        <h2>{{ $title }}</h2>
        <p>Total de carreras: {{ number_format($sum) }}</p>
    </center>
    <canvas id="study_programs" class="pie-chart m-auto"></canvas>
    <script type="module">
        let labels=[]
        let data=[]

        @foreach ($statistics as $type=>$data)
            @if ($type!="Escuelas")
                labels.push("{{ $type }}");
                data.push({{ $data['carriers'] }});
            @endif
        @endforeach

        let datasets=[]
        
        let study_programs={
            labels: labels,
            datasets: [{
                data: data
            }]
        }

        new Chart("study_programs", {
            type: "pie",
            data: study_programs,
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