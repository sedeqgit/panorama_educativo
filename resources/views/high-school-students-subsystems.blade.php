@extends('layouts.app')

@section('title','Alumnos por Subsistema en Educación Media Superior')

@vite(['resources/css/tables.css','resources/js/chart.js','resources/css/charts.css'])

@section('content')
    <center>
        <h2>Alumnos por Subsistema en Educación Media Superior</h2>
    </center>
    <div>
    <table class="table table-bordered border-black mt-4 m-auto w-auto qro-table-header align-middle">
        <thead class="text-center align-middle">
            <tr>
                <th rowspan="2">Municipio</th>
                <th colspan="{{ count($subsystems)-1 }}">Subsistema</th>
                <th rowspan="2">Total</th>
            </tr>
            <tr>
                @foreach($subsystems as $subsystem)
                    @if ($subsystem!="Abierta")
                        <th>{{ $subsystem }}</th>
                    @endif
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
                        @if ($subsystem!="Abierta")
                            @php
                                $students=$data['male_students'] + $data['female_students'];
                                $municipality_total+=$students;
                            @endphp
                            @if($students>0)
                                <td class="text-center">{{ number_format($students) }}</td>
                            @else
                                <td class="text-center"></td>
                            @endif
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
                        if ($subsystem!="Abierta"){
                            $students=$data['male_students'] + $data['female_students'];
                            $municipality_total+=$students;
                        }
                    }
                @endphp
                @foreach ($totals_by_subsystem as $subsystem => $data)
                    @if ($subsystem!="Abierta")
                        <td class="text-center">{{ number_format($students) }}</td>
                    @endif
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
    <div class="position-absolute start-50 translate-middle-x">
        <canvas id="students_high_school_subsystems" class="bar-chart m-auto"></canvas>
        * CAED: Centro de Atención para Estudiantes con Discapacidad.
        <br>
        ** Incluye alumnos de modalidades Escolarizado, No Escolarizado y Mixto
    </div>
    <script type="module">
        let labels=[];
        let data=[];

        @foreach ($totals_by_subsystem as $subsystem => $data)
            @if ($subsystem!="Abierta")
                @if ($subsystem=="CAED")
                    labels.push("{{ $subsystem }} *");
                @else
                    labels.push("{{ $subsystem }}");
                @endif
                data.push({{ $data['male_students'] + $data['female_students'] }});
            @endif
        @endforeach
        
        let students_high_school_subsystems={
            labels: labels,
            datasets: [
                {
                    data: data
                }
            ]
        }
        console.log

        new Chart("students_high_school_subsystems", {
            type: "bar",
            data: students_high_school_subsystems,
            options: {
                responsive: true,
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