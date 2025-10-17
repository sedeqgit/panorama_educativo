@extends('layouts.app')

@section('title','Planteles por Subsistema en educación Media Superior')

@vite(['resources/css/tables.css','resources/js/chart.js','resources/css/charts.css'])

@section('content')
    <center>
        <h2>Planteles por Subsistema en educación Media Superior</h2>
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
                        foreach ($subsystems as $subsystem => $data){
                            $schools=$data['school_count'];
                            echo '<td class="text-center">'.number_format($schools).'</td>';
                            $municipality_total+=$schools;
                        }
                    @endphp
                    <td class="text-center">{{ number_format($municipality_total) }}</td>
                </tr>
            @endforeach
            <tr>
                <td>Total</td>
                @php
                    $municipality_total=0;
                    foreach ($totals_by_subsystem as $subsystem => $data){
                        $schools=$data['school_count'];
                        echo '<td class="text-center">'.number_format($schools).'</td>';
                        $municipality_total+=$schools;
                    }
                @endphp
                <td class="text-center">{{ number_format($municipality_total) }}</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="{{ count($subsystems)+2 }}">* Incluye alumnos de modalidades Escolarizado, No Escolarizado y Mixto</td>
            </tr>
        </tfoot>
    </table>
    <canvas id="schools_high_school_subsystems" class="bar-chart m-auto"></canvas>
    <script type="module">
        let labels=[];
        let data=[];

        @foreach ($totals_by_subsystem as $subsystem => $data)
            labels.push("{{ $subsystem }}");
            data.push({{ $data['school_count'] }});
        @endforeach
        
        let schools_high_school_subsystems={
            labels: labels,
            datasets: [
                {
                    data: data
                }
            ]
        }
        console.log

        new Chart("schools_high_school_subsystems", {
            type: "bar",
            data: schools_high_school_subsystems,
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