@extends('layouts.app')

@vite(['resources/css/tables.css','resources/js/charts.js','resources/css/charts.css', 'resources/js/graficos.js'])
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoeqMV/TJlSKda6FXzoEyYGjTe+vXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

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
    <div class="text-center my-3">
        <button class="btn boton-descarga descargar-tabla-btn" 
                data-target-id="datosTabla" 
                data-filename="Docentes-por-tipo-o-nivel-educativo-y-por-sostenimiento-{{$period}}.png">Descargar tabla</button>
    </div>
    <table id="datosTabla" class="table table-bordered border-black mt-4 m-auto w-auto qro-table-header align-middle">
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
                    @switch($level)
                        @case("Media Superior")
                            <td>{{ $level }} *</td>
                            @break
                        @case("Superior")
                            <td>{{ $level }} */**</td>
                            @break
                        @default
                            <td>{{ $level }}</td>
                    @endswitch
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
                    <td class="text-center fw-bold important-col">
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
    <div class="container text-center">
        <div class="mt-2"><!--boton de descarga de grafica-->
            <button id="descargarGraficaBtn" class="btn boton-descarga">Descargar gráfica</button>
        </div>
        <canvas id="teachers_school_level_sustenance" class="bar-chart m-auto mt-2"></canvas>
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

        const myChart = new Chart("teachers_school_level_sustenance", {
            type: "bar",
            data: teachers_school_level_sustenance,
            options: {
                responsive: true,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: "Tipo o nivel educativo",
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

        document.getElementById('descargarGraficaBtn').addEventListener('click', function () {
            const enlace = document.createElement('a');
            enlace.href = myChart.toBase64Image(); // Convierte el canvas a imagen
            enlace.download = `Docentes-por-tipo-o-nivel-educativo-y-por-sostenimiento-{{$period}}.png`; // Nombre del archivo
            enlace.click();
        });
    </script>
@include('layouts.footer')
@endsection