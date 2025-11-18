@extends('layouts.app')

@vite(['resources/css/tables.css','resources/js/chart.js','resources/css/charts.css'])

@php
    function calculate_percentage($number,$total){
        if($number==0 && $total==0) return 0;
        return round(($number / $total) * 100, 2);
    }
    $total=0;
    foreach ($totals as $sustenancetype => $data) {
        $total+=$data['male_teachers'] + $data['female_teachers'];
    }
    $route=request()->route()->uri();
    $period=implode('/',array_slice(explode('/',$route),0,1));
@endphp

@section('title', 'Docentes por tipo o nivel educativo y por sostenimiento ('.$period.')')

@section(section: 'content')
    <center>
        <h2>Docentes por tipo o nivel educativo y por sostenimiento ({{ $period }})</h2>
    </center>
    <table class="table table-bordered border-black mt-4 m-auto w-auto qro-table-header align-middle">
        <thead class=" text-center align-middle">
            <tr>
                <th rowspan="2">Nivel</th>
                <th colspan="3">Docentes</th>
            </tr>
            <tr>
                <th>Públicas</th>
                <th>Privadas</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($statistics as $level=>$sustenancetypes)
                <tr>
                    @if ($level=="Media Superior")
                        <td>{{ $level }} *</td>
                    @elseif ($level=="Superior")
                        <td>{{ $level }} */**</td>
                    @else
                        <td>{{ $level }}</td>
                    @endif
                    @php
                        $subtotal=0;
                        foreach ($sustenancetypes as $sustenancetype => $data) {
                            $subtotal+=$data['male_teachers'] + $data['female_teachers'];
                        }
                    @endphp
                    @foreach ($sustenancetypes as $sustenancetype => $data)
                        <td class="text-center">
                            {{ number_format($data['male_teachers'] + $data['female_teachers']) }}
                            <br>
                            {{ calculate_percentage($data['male_teachers'] + $data['female_teachers'],$subtotal) }}%
                        </td>
                    @endforeach
                    <td class="text-center">
                        {{ number_format($subtotal) }}
                        <br>
                        {{ calculate_percentage($subtotal,$total) }}%
                    </td>
                </tr>
            @endforeach
            <tr class="important-row">
                <td>Totales</td>
                @foreach ($totals as $sustenancetype => $data)
                    <td class="text-center">{{ number_format($data['male_teachers'] + $data['female_teachers']) }}</td>
                @endforeach
                <td class="text-center">{{ number_format($total) }}</td>
            </tr>
        </tbody>
        <tfoot class="table-borderless">
            <tr>
                <td colspan="7">
                    * Incluye docentes de modalidades Escolarizado, No Escolarizado y Mixto
                    <br>
                    ** Incluye TSU, Licenciatura y Posgrado
                </td>
            </tr>
        </tfoot>
    </table>
    <center class="mt-4">
        <h2>Docentes por tipo o nivel educativo y por sostenimiento ({{ $period }})</h2>
    </center>
    <div class="position-absolute start-50 translate-middle-x">
        <canvas id="teachers_school_level_sustenance" class="bar-chart m-auto"></canvas>
        * Incluye docentes de modalidades Escolarizado, No Escolarizado y Mixto
        <br>
        ** Incluye TSU, Licenciatura y Posgrado
    </div>
    <script type="module">
        let labels=[]
        let datasetsMap=[]

        @foreach ($statistics as $level=>$sustenancetypes)
            labels.push("{{ $level }}")
            @foreach ($sustenancetypes as $sustenancetype=>$data)
                if(!datasetsMap["{{ $sustenancetype }}"]){
                    datasetsMap["{{ $sustenancetype }}"] = [];
                }
                datasetsMap["{{ $sustenancetype }}"].push({{ $data['male_teachers'] + $data['female_teachers'] }});
            @endforeach
        @endforeach

        let datasets=[]

        for (const key in datasetsMap){
            datasets.push({
                label: key,
                data: datasetsMap[key]
            })
        }
        
        let teachers_school_level_sustenance={
            labels: labels,
            datasets: datasets
        }

        new Chart("teachers_school_level_sustenance", {
            type: "bar",
            data: teachers_school_level_sustenance,
            options: {
                responsive: true,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: "Nivel educativo",
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
                    }
                }
            }
        });
    </script>
@endsection