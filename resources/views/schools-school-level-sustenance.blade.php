@extends('layouts.app')

@section('title', 'Escuelas por tipo o nivel educativo y por sostenimiento')

@vite(['resources/css/tables.css','resources/js/chart.js','resources/css/charts.css'])

@php
    function calculate_percentage($number,$total){
        if($number==0 && $total==0) return 0;
        return round(($number / $total) * 100, 2);
    }
    $total=0;
    foreach ($totals as $sustenancetype => $data) {
        $total+=$data['school_count'];
    }
@endphp

@section(section: 'content')
    <center>
        <h2>Escuelas por tipo o nivel educativo y por sostenimiento</h2>
    </center>
    <table class="table table-bordered border-black mt-4 m-auto w-auto qro-table-header align-middle">
        <thead class="text-center align-middle">
            <tr>
                <th rowspan="2">Nivel</th>
                <th colspan="3">Escuelas</th>
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
                            $subtotal=0;
                            foreach ($sustenancetypes as $sustenancetype => $data) {
                                $subtotal+=$data['school_count'];
                            }
                        @endphp
                        @foreach ($sustenancetypes as $sustenancetype => $data)
                        <td class="text-center">
                            {{ number_format($data['school_count']) }}
                            <br>
                            {{ calculate_percentage($data['school_count'],$subtotal) }}%
                        </td>
                    @endforeach
                    <td class="text-center">
                        {{ number_format($subtotal) }}
                        <br>
                        {{ calculate_percentage($subtotal,$total) }}%
                    </td>
                    </tr>
                @endif
            @endforeach
            <tr>
                <td>Totales</td>
                @foreach ($totals as $sustenancetype => $data)
                    <td class="text-center">{{ number_format($data['school_count']) }}</td>
                @endforeach
                <td class="text-center">{{ number_format($total) }}</td>
            </tr>
        </tbody>
        <tfoot class="table-borderless">
            <tr>
                <td colspan="7">
                    * En el total de Escuelas de Media Superior se cuantifican planteles y en Superior se cuantifican instituciones.
                    <br>
                    ** Incluye TSU, Licenciatura y Posgrado
                </td>
            </tr>
        </tfoot>
    </table>
    <div class="position-absolute start-50 translate-middle-x">
        <canvas id="schools_school_level_sustenance" class="bar-chart m-auto"></canvas>
        * En el total de Escuelas de Media Superior se cuantifican planteles y en Superior se cuantifican instituciones.
        <br>
        ** Incluye TSU, Licenciatura y Posgrado
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

                    datasetsMap["{{ $sustenancetype }}"].push({{ $data['school_count'] }});
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
        
        let schools_school_level_sustenance={
            labels: labels,
            datasets: datasets
        }

        new Chart("schools_school_level_sustenance", {
            type: "bar",
            data: schools_school_level_sustenance,
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
                            text: "Cantidad de escuelas",
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