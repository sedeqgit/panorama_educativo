@extends('layouts.app')

@section('title','Matrícula en Media Superior por Subsistema')

@vite(['resources/css/tables.css','resources/js/chart.js','resources/css/charts.css'])

@section('content')
    <center>
        <h2>Matrícula en Media Superior por Subsistema</h2>
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
                            $students=$data['male_students'] + $data['female_students'];
                            $municipality_total+=$students;
                        @endphp
                        @if($students>0)
                            <td class="text-center">{{ number_format($students) }}</td>
                        @else
                            <td class="text-center"></td>
                        @endif
                    @endforeach
                    <td class="text-center">{{ number_format($municipality_total) }}</td>
                </tr>
            @endforeach
            <tr>
                <td>Total</td>
                @php
                    $municipality_total=0;
                    foreach ($totals_by_subsystem as $subsystem => $data){
                        $students=$data['male_students'] + $data['female_students'];
                        $municipality_total+=$students;
                    }
                @endphp
                @foreach ($totals_by_subsystem as $subsystem => $data)
                    <td class="text-center">{{ number_format($students) }}</td>
                @endforeach
                <td class="text-center">{{ number_format($municipality_total) }}</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="{{ count($subsystems)+2 }}">* Incluye alumnos de modalidades Escolarizado, No Escolarizado y Mixto</td>
            </tr>
        </tfoot>
    </table>
    <div class="position-absolute start-50 translate-middle-x my-4">
        <center>Matrícula total: {{ number_format($municipality_total) }}</center>
        <canvas id="students_high_school_subsystems" class="bar-chart m-auto"></canvas>
        * CAED: Centro de Atención para Estudiantes con Discapacidad.
        <br>
        ** Incluye alumnos de modalidades Escolarizado, No Escolarizado y Mixto
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
            data.push({{ $data['male_students'] + $data['female_students'] }});
        @endforeach
        
        let students_high_school_subsystems={
            labels: labels,
            datasets: [
                {
                    data: data
                }
            ]
        }

        new Chart("students_high_school_subsystems", {
            type: "bar",
            data: students_high_school_subsystems,
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
                            text: "Cantidad de alumnos",
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