@extends('layouts.app')

@section('title', 'Proporción de alumnos atendidos por tipo o nivel educativo')

@vite(['resources/css/tables.css','resources/js/chart.js','resources/css/charts.css'])

@section(section: 'content')
    <center>
        <h2>Proporción de alumnos atendidos por tipo o nivel educativo</h2>
    </center>
    <div class="position-absolute start-50 translate-middle-x">
    <canvas id="students_school_level_ratio" class="pie-chart m-auto"></canvas>
        @if (isset($statistics["Media Superior"]) || isset($statistics["Superior"]))
            * Incluye alumnos de modalidades Escolarizado, No Escolarizado y Mixto
            <br>
        @endif
        @if (isset($statistics["Superior"]))
            ** Incluye TSU, Licenciatura y Posgrado
        @endif
    </div>
    <script type="module">
        let labels=[]
        let data=[]

        @foreach ($statistics as $level=>$data)
            @if ( $level != "Especial (USAER)")
                @if ($level=="Media Superior")
                    labels.push("{{ $level }} *");
                @elseif ($level=="Superior")
                    labels.push("{{ $level }} */**");
                @else
                    labels.push("{{ $level }}");
                @endif
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

        new Chart("students_school_level_ratio", {
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
    </script>
@endsection