@extends('layouts.app')

@vite(['resources/css/tables.css', 'resources/js/charts.js', 'resources/css/charts.css', 'resources/js/graficos.js'])
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoeqMV/TJlSKda6FXzoEyYGjTe+vXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

@php
    function calculate_percentage($number,$total){
        if($number==0 && $total==0) return 0;
        return round(($number / $total) * 100, 2);
    }
    $route=request()->route()->uri();
    $period=implode('/',array_slice(explode('/',$route),0,1));
@endphp

@section('title','Alumnos y docentes por género ('.$period.')')

@section('content')
    <center>
        <h2>Alumnos y docentes por género ({{ $period }})</h2>
    </center>
    <div class="text-center my-3">
        <button class="btn boton-descarga descargar-tabla-btn" 
                data-target-id="datosTabla" 
                data-filename="Alumnos-y-docentes-por-genero-{{$period}}.png">Descargar tabla</button>
    </div>
    <table id="datosTabla" class="table table-bordered border-black mt-4 m-auto w-auto qro-table-header align-middle">
        <thead class="text-center align-middle">
            <tr>
                <th rowspan="2">Nivel</th>
                <th colspan="3">Alumnos</th>
                <th colspan="3">Docentes</th>
            </tr>
            <tr>
                <th>Total</th>
                <th>Hombres</th>
                <th>Mujeres</th>
                <th>Total</th>
                <th>Hombres</th>
                <th>Mujeres</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($statistics as $level => $data)
                <tr>
                    @switch($level)
                        @case("Especial (USAER)")
                            <td>{{ $level }} *</td>
                            @break
                        @case("Media Superior")
                            <td>{{ $level }} **</td>
                            @break
                        @case("Superior")
                            <td>{{ $level }} **/***</td>
                        @break
                        @default
                            <td>{{ $level }}</td>
                    @endswitch
                    @if ($level!="Especial (USAER)")
                        <td class="text-center important-column">
                            {{ number_format($data['male_students'] + $data['female_students']) }}
                            <br>
                            {{ calculate_percentage($data['male_students'] + $data['female_students'],$totals['male_students'] + $totals['female_students']) }}%
                        </td>
                    @else
                        <td class="text-center important-column">{{ number_format($data['male_students'] + $data['female_students']) }}</td>
                    @endif
                    <td class="text-center">
                        {{ number_format($data['male_students']) }}
                        <br>
                        {{ calculate_percentage($data['male_students'],$data['male_students'] + $data['female_students']) }}%
                    </td>
                    <td class="text-center">
                        {{ number_format($data['female_students']) }}
                        <br>
                        {{ calculate_percentage($data['female_students'],$data['male_students'] + $data['female_students']) }}%
                    </td>
                    <td class="text-center important-column">
                        {{ number_format($data['male_teachers'] + $data['female_teachers']) }}
                        <br>
                        {{ calculate_percentage($data['male_teachers'] + $data['female_teachers'],$totals['male_teachers'] + $totals['female_teachers']) }}%
                    </td>
                    <td class="text-center">
                        {{ number_format($data['male_teachers']) }}
                        <br>
                        {{ calculate_percentage($data['male_teachers'],$data['male_teachers'] + $data['female_teachers']) }}%
                    </td>
                    <td class="text-center">
                        {{ number_format($data['female_teachers']) }}
                        <br>
                        {{ calculate_percentage($data['female_teachers'],$data['male_teachers'] + $data['female_teachers']) }}%
                    </td>
                </tr>
            @endforeach
            <tr class="important-row">
                <td>Básica + Media Superior + Superior</td>
                <td class="text-center">{{ number_format($totals['male_students'] + $totals['female_students']) }}</td>
                <td class="text-center">{{ number_format($totals['male_students']) }}</td>
                <td class="text-center">{{ number_format($totals['female_students']) }}</td>
                <td class="text-center">{{ number_format($totals['male_teachers'] + $totals['female_teachers']) }}</td>
                <td class="text-center">{{ number_format($totals['male_teachers']) }}</td>
                <td class="text-center">{{ number_format($totals['female_teachers']) }}</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="7">
                    * La estadística de alumnos en los servicios USAER no se suma en básica ya que se cuantifica en los niveles correspondientes
                    <br>
                    ** Incluye alumnos y docentes de modalidades Escolarizado, No Escolarizado y Mixto
                    <br>
                    *** Incluye TSU, Licenciatura y Posgrado
                </td>
            </tr>
        </tfoot>
    </table>
    <div class="container mt-4 text-center">
        <div class="d-flex justify-content-center">
            <div class="btn-group" role="group">
                <input type="radio" name="options" id="students" class="btn-check" checked>
                <label class="btn btn-outline-primary" for="students">Alumnos</label>
                <input type="radio" name="options" id="teachers" class="btn-check">
                <label class="btn btn-outline-primary" for="teachers">Docentes</label>
            </div>
        </div>
        <div class="mt-4">
            <h2 id="chart-title">Alumnos por género ({{ $period }})</h2>
        </div>
        <div class="mt-2"><!--boton de descarga de grafica-->
            <button id="descargarGraficaBtn" class="btn boton-descarga">Descargar gráfica</button>
        </div>
        <canvas id="students_teachers_gender" class="bar-chart m-auto"></canvas>
    </div>
    @include('layouts.footer')
    <script type="module">
        const radioButtons=document.querySelectorAll('input[type="radio"]');
        const chartTitle=document.getElementById("chart-title");

        const chart = new Chart("students_teachers_gender", {
            type: "bar",
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

                }
            }
        });

        function update_chart(option){
            let labels=[];
            let datasetsMap=[];
            let datasets=[]
            let title;
            let yTitle;
            switch (option) {
                case 'students':
                    @foreach ($statistics as $level=>$data)
                        labels.push("{{ $level }}");
                        if(!datasetsMap["Hombres"]) datasetsMap["Hombres"]=[];
                        if(!datasetsMap["Mujeres"]) datasetsMap["Mujeres"]=[];
                        datasetsMap["Hombres"].push({{ $data['male_students'] }});
                        datasetsMap["Mujeres"].push({{ $data['female_students'] }});
                    @endforeach
                    title="Alumnos por género ({{ $period }})";
                    yTitle="Alumnos atendidos";
                    break;
                case 'teachers':
                    @foreach ($statistics as $level=>$data)
                        labels.push("{{ $level }}");
                        if(!datasetsMap["Hombres"]) datasetsMap["Hombres"]=[];
                        if(!datasetsMap["Mujeres"]) datasetsMap["Mujeres"]=[];
                        datasetsMap["Hombres"].push({{ $data['male_teachers'] }});
                        datasetsMap["Mujeres"].push({{ $data['female_teachers'] }});
                    @endforeach
                    title="Docentes por género ({{ $period }})";
                    yTitle="Cantidad de docentes";
                    break;
            }
            for (const key in datasetsMap){
                datasets.push({
                    label: key,
                    data: datasetsMap[key]
                })
            }
            let students_teachers_gender={
                labels: labels,
                datasets: datasets
            }
            chartTitle.innerHTML=title;
            chart.data=students_teachers_gender;
            chart.options.scales.y.title.text=yTitle;
            chart.update();
        }

        update_chart('students');

        radioButtons.forEach(radioButton => {
            radioButton.addEventListener('change', () => update_chart(radioButton.id));
        });

        document.getElementById('descargarGraficaBtn').addEventListener('click', function () {
            const enlace = document.createElement('a');
            enlace.href = chart.toBase64Image(); // Convierte el canvas a imagen
            enlace.download = `Alumnos-y-docentes-por-genero-{{$period}}.png`; // Nombre del archivo
            enlace.click();
        });
    </script>
@include('layouts.footer')
@endsection
