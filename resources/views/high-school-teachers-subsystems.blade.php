@extends('layouts.app')

@vite(['resources/css/tables.css','resources/js/chart.js','resources/css/charts.css'])

@php
    $route=request()->route()->uri();
    $period=implode('/',array_slice(explode('/',$route),0,1));
@endphp

@section('title','Docentes por Subsistema en Educación Media Superior ('.$period.')')

@section('content')
    <center>
        <h2>Docentes por Subsistema en Educación Media Superior ({{ $period }})</h2>
    </center>
    <div>
    <table class="table table-bordered border-black mt-4 m-auto w-auto qro-table-header align-middle">
        <thead class="text-center align-middle">
            <tr>
                <th rowspan="2">Municipio</th>
                <th colspan="{{ count($subsystems) }}">Subsistema</th>
                <th rowspan="2">Total</th>
            </tr>
            <tr>
                @foreach($subsystems as $subsystem)
                    <th>{{ $subsystem }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($statistics as $municipality => $subsystems)
                <tr>
                    <td>{{ $municipality }}</td>
                    @php
                        $municipality_total=0;
                    @endphp
                    @foreach ($subsystems as $subsystem => $data)
                        @php
                            $teachers=$data['male_teachers'] + $data['female_teachers'];
                            $municipality_total+=$teachers;
                        @endphp
                        @if($teachers>0)
                            <td class="text-center">{{ number_format($teachers) }}</td>
                        @else
                            <td class="text-center"></td>
                        @endif
                    @endforeach
                    <td class="text-center important-column">{{ number_format($municipality_total) }}</td>
                </tr>
            @endforeach
            <tr class="important-row">
                <td>Total</td>
                @php
                    $municipality_total=0;
                    foreach ($totals_by_subsystem as $subsystem => $data){
                        $teachers=$data['male_teachers'] + $data['female_teachers'];
                        echo '<td class="text-center">'.number_format($teachers).'</td>';
                        $municipality_total+=$teachers;
                    }
                @endphp
                <td class="text-center">{{ number_format($municipality_total) }}</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="{{ count($subsystems)+2 }}">* Incluye docentes de modalidades Escolarizado, No Escolarizado y Mixto</td>
            </tr>
        </tfoot>
    </table>
    <center class="mt-4">
        <h2>Docentes por Subsistema en Educación Media Superior ({{ $period }})</h2>
    </center>
    <div class="position-absolute start-50 translate-middle-x my-4">
        <center>Total de docentes: {{ number_format($municipality_total) }}</center>
        <canvas id="teachers_high_school_subsystems" class="bar-chart m-auto"></canvas>
        * CAED: Centro de Atención para Estudiantes con Discapacidad.
        <br>
        * Incluye docentes de modalidades Escolarizado, No Escolarizado y Mixto
    </div>
    <script type="module">
        let labels=[];
        let data=[];

        @foreach ($totals_by_subsystem as $subsystem => $data)
            @if ($subsystem=="CAED")
                labels.push("{{ $subsystem }} *");
            @else
                labels.push("{{ $subsystem }}");
            @endif
            data.push({{ $data['male_teachers'] + $data['female_teachers'] }});
        @endforeach
        
        let teachers_high_school_subsystems={
            labels: labels,
            datasets: [
                {
                    data: data
                }
            ]
        }

        new Chart("teachers_high_school_subsystems", {
            type: "bar",
            data: teachers_high_school_subsystems,
            options: {
                responsive: true,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: "Subsistemas",
                            font: {
                                size: 14,
                                weight: 'bold'
                            }
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: "Cantidad de docentes",
                            font: {
                                size: 14,
                                weight: 'bold'
                            }
                        }
                    }
                },
                plugins: {
                    datalabels: {
                        anchor: "end",
                        align: "top",
                    },
                    legend: {
                        display: false
                    }
                }
            }
        });
    </script>
@endsection