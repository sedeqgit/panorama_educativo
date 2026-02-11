@extends('layouts.app')

@vite(['resources/css/high-school-tables.css','resources/js/high-school-charts.js','resources/css/charts.css', 'resources/js/graficos.js', ])
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoeqMV/TJlSKda6FXzoEyYGjTe+vXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

@php
    $route=request()->route()->uri();
    $period=implode('/',array_slice(explode('/',$route),0,1));
@endphp

@section('title','Matrícula en Media Superior por Subsistema ('.$period.')')

@section('content')
    <center>
        <h2>Matrícula en Media Superior por Subsistema ({{ $period }})</h2>
    </center>
    <div class="container">
        <center>Matrícula total: {{ number_format($totals['male_students'] + $totals['female_students']) }}</center>

        <center class="mt-2"><!--boton de descarga de grafica-->
            <button id="descargarGraficaBtn" class="btn boton-descarga">Descargar gráfica</button>
        </center>
        <canvas id="students_high_school_subsystems" class="bar-chart m-auto"></canvas>
        * CAED: Centro de Atención para Estudiantes con Discapacidad.
        <br>
        ** Incluye alumnos de modalidades Escolarizado, No Escolarizado y Mixto
    </div>
    <center class="mt-4">
        <h2>Matrícula en Media Superior por Subsistema ({{ $period }})</h2>
    </center>
    <div class="text-center my-3">
        <button class="btn boton-descarga descargar-tabla-btn" 
                data-target-id="datosTabla" 
                data-filename="Matricula-en-Media-Superior-por-Subsistema-{{$period}}.png">Descargar tabla</button>
    </div>
    <table id="datosTabla" class="table table-bordered border-black mt-4 m-auto w-auto qro-table-header align-middle">
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
                    <td class="text-center important-column">{{ number_format($municipality_total) }}</td>
                </tr>
            @endforeach
            <tr class="important-row">
                <td>Total</td>
                @php
                    $municipality_total=0;
                @endphp
                @foreach ($totals_by_subsystem as $subsystem => $data)
                    @php
                        $students=$data['male_students'] + $data['female_students'];
                        $municipality_total+=$students;
                    @endphp
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

        const myChart = new Chart("students_high_school_subsystems", {
            type: "bar",
            data: students_high_school_subsystems,
            /*plugins: [{ /*configuracion de backgrond
                id: 'customCanvasBackgroundColor',
                beforeDraw: (chart, args, options) => {
                    const {
                        ctx
                    } = chart;
                    ctx.save();
                    ctx.globalCompositeOperation = 'destination-over';
                    ctx.fillStyle = options.color || 'white';
                    ctx.fillRect(0, 0, chart.width, chart.height);
                    ctx.restore();
                }
            }],*/
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
        
        document.getElementById('descargarGraficaBtn').addEventListener('click', function () {
            const enlace = document.createElement('a');
            enlace.href = myChart.toBase64Image(); // Convierte el canvas a imagen
            enlace.download = `grafica-students-high-school-subsistema-{{$period}}.png`; // Nombre del archivo
            enlace.click();
        });
    </script>
@include('layouts.footer')
@endsection

