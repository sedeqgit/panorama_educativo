@extends('layouts.app')

@section('title', 'Alumnos atendidos por tipo o nivel educativo y por sostenimiento')

@vite(['resources/css/tables.css','resources/js/chart.js','resources/css/charts.css'])

@section(section: 'content')
    <center>
        <h2>Alumnos atendidos por tipo o nivel educativo y por sostenimiento</h2>
    </center>
    <table class="table table-bordered border-black mt-4 m-auto w-auto qro-table-header align-middle">
        <thead class="text-center align-middle">
            <tr>
                <th rowspan="2">Nivel</th>
                <th colspan="3">Alumnos</th>
            </tr>
            <tr>
                <th>Públicas</th>
                <th>Privadas</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($statistics as $level=>$sustenancetypes)
                @if ( $level != "Especial (USAER)")
                    <tr>
                        @if ($level=="Media Superior")
                            <td>{{ $level }} *</td>
                        @elseif ($level=="Superior")
                            <td>{{ $level }} */**</td>
                        @else
                            <td>{{ $level }}</td>
                        @endif
                        @php
                            $total=0;
                            foreach ($sustenancetypes as $sustenancetype => $data) {
                                $total+=$data['male_students'] + $data['female_students'];
                            }
                        @endphp
                        <td class="text-center">{{ number_format($sustenancetypes["Público"]['male_students'] + $sustenancetypes["Público"]['female_students']) }}</td>
                        <td class="text-center">{{ number_format($sustenancetypes["Privado"]['male_students'] + $sustenancetypes["Privado"]['female_students']) }}</td>
                        <td class="text-center">{{ number_format($total) }}</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="7">
                    @if (isset($statistics["Media Superior"]) || isset($statistics["Superior"]))
                        * Incluye alumnos de modalidades Escolarizado, No Escolarizado y Mixto
                        <br>
                    @endif
                    @if (isset($statistics["Superior"]))
                        ** Incluye TSU, Licenciatura y Posgrado
                    @endif
                </td>
            </tr>
        </tfoot>
    </table>
    <div class="position-absolute start-50 translate-middle-x">
        <canvas id="students_school_level_sustenance" class="bar-chart m-auto"></canvas>
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
        let datasetsMap=[]

        @foreach ($statistics as $level=>$sustenancetypes)
            @if ( $level != "Especial (USAER)")
                @if ($level=="Media Superior")
                    labels.push("{{ $level }} *");
                @elseif ($level=="Superior")
                    labels.push("{{ $level }} */**");
                @else
                    labels.push("{{ $level }}");
                @endif
                @foreach ($sustenancetypes as $sustenancetype=>$data)
                    if(!datasetsMap["{{ $sustenancetype }}"]){
                        datasetsMap["{{ $sustenancetype }}"] = [];
                    }
                    datasetsMap["{{ $sustenancetype }}"].push({{ $data['male_students'] + $data['female_students'] }});
                @endforeach
            @endif
        @endforeach

        let datasets=[]

        for (const key in datasetsMap){
            datasets.push({
                label: key,
                data: datasetsMap[key]
            })
        }
        
        let students_school_level_sustenance={
            labels: labels,
            datasets: datasets
        }

        new Chart("students_school_level_sustenance", {
            type: "bar",
            data: students_school_level_sustenance,
            options: {
                responsive: true,
                plugins: {
                    datalabels: {
                        anchor: "end",
                        align: "top",
                    }
                }
            }
        });
    </script>
@endsection