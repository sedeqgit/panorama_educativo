@extends('layouts.app')

@vite(['resources/css/high-school-tables.css','resources/js/high-school-charts.js','resources/css/charts.css', 'resources/js/graficos.js', ])
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoeqMV/TJlSKda6FXzoEyYGjTe+vXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

@php
    $totals=[];
    function calculate_percentage($number,$total){
        if($number==0 && $total==0) return 0;
        return round(($number / $total) * 100, 2);
    }
    ksort($statistics);
    $route=request()->route()->uri();
    $period=implode('/',array_slice(explode('/',$route),0,1));
@endphp

@section('title','Alumnos, Alumnos de Nuevo Ingreso  y Egresados por Subsistemas ('.$period.')')

@section('content')
    <center>
        <h2>Alumnos, Alumnos de Nuevo Ingreso  y Egresados por Subsistemas ({{ $period }})</h2>
    </center>
    <div class="text-center my-3">
        <button class="btn boton-descarga descargar-tabla-btn" 
                data-target-id="tabla" 
                data-filename="Alumnos-por-Subsistema-{{$period}}.png">Descargar tabla</button>
    </div>
    
    <table id="tabla" class="table table-bordered border-black mt-4 m-auto w-auto qro-table-header align-middle">
        <thead class="text-center align-middle">
            <tr>
                <th rowspan="2">Subsistema</th>
                <th colspan="5">Alumnos</th>
                <th colspan="5">Nuevo ingreso</th>
                <th colspan="5">Egresados</th>
            </tr>
            <tr>
                <th>Total</th>
                <th>Hombres</th>
                <th>Mujeres</th>
                <th>%H</th>
                <th>%M</th>
                <th>Total</th>
                <th>Hombres</th>
                <th>Mujeres</th>
                <th>%H</th>
                <th>%M</th>
                <th>Total</th>
                <th>Hombres</th>
                <th>Mujeres</th>
                <th>%H</th>
                <th>%M</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($statistics as $subsystem => $data)
                <tr>
                    <td>{{ $subsystem }}</td>
                    <td class="text-center fw-bold">{{ number_format($data['male_students'] + $data['female_students']) }}</td>
                    <td class="text-center">{{ number_format($data['male_students']) }}</td>
                    <td class="text-center">{{ number_format($data['female_students']) }}</td>
                    <td class="text-center important-column">{{ calculate_percentage($data['male_students'],$data['male_students'] + $data['female_students']) }}%</td>
                    <td class="text-center important-column">{{ calculate_percentage($data['female_students'],$data['male_students'] + $data['female_students']) }}%</td>
                    <td class="text-center fw-bold">{{ number_format($data['new_male_students'] + $data['new_female_students']) }}</td>
                    <td class="text-center">{{ number_format($data['new_male_students']) }}</td>
                    <td class="text-center">{{ number_format($data['new_female_students']) }}</td>
                    <td class="text-center important-column">{{ calculate_percentage($data['new_male_students'],$data['new_male_students'] + $data['new_female_students']) }}%</td>
                    <td class="text-center important-column">{{ calculate_percentage($data['new_female_students'],$data['new_male_students'] + $data['new_female_students']) }}%</td>
                    <td class="text-center fw-bold">{{ number_format($data['graduate_male_students'] + $data['graduate_female_students']) }}</td>
                    <td class="text-center">{{ number_format($data['graduate_male_students']) }}</td>
                    <td class="text-center">{{ number_format($data['graduate_female_students']) }}</td>
                    <td class="text-center important-column">{{ calculate_percentage($data['graduate_male_students'],$data['graduate_male_students'] + $data['graduate_female_students']) }}%</td>
                    <td class="text-center important-column">{{ calculate_percentage($data['graduate_female_students'],$data['graduate_male_students'] + $data['graduate_female_students']) }}%</td>
                    @php
                        $totals['male_students'] = ($totals['male_students'] ?? 0) + ($data['male_students']);
                        $totals['female_students'] = ($totals['female_students'] ?? 0) + ($data['female_students']);
                        $totals['new_male_students'] = ($totals['new_male_students'] ?? 0) + ($data['new_male_students']);
                        $totals['new_female_students'] = ($totals['new_female_students'] ?? 0) + ($data['new_female_students']);
                        $totals['graduate_male_students'] = ($totals['graduate_male_students'] ?? 0) + ($data['graduate_male_students']);
                        $totals['graduate_female_students'] = ($totals['graduate_female_students'] ?? 0) + ($data['graduate_female_students']);
                    @endphp
                </tr>
            @endforeach
            <tr class="important-row">
                <td>Totales</td>
                <td class="text-center">{{ number_format($totals['male_students'] + $totals['female_students']) }}</td>
                <td class="text-center">{{ number_format($totals['male_students']) }}</td>
                <td class="text-center">{{ number_format($totals['female_students']) }}</td>
                <td class="text-center">{{ calculate_percentage($totals['male_students'],$totals['male_students'] + $totals['female_students']) }}%</td>
                <td class="text-center">{{ calculate_percentage($totals['female_students'],$totals['male_students'] + $totals['female_students']) }}%</td>
                <td class="text-center">{{ number_format($totals['new_male_students'] + $totals['new_female_students']) }}</td>
                <td class="text-center">{{ number_format($totals['new_male_students']) }}</td>
                <td class="text-center">{{ number_format($totals['new_female_students']) }}</td>
                <td class="text-center">{{ calculate_percentage($totals['new_male_students'],$totals['new_male_students'] + $totals['new_female_students']) }}%</td>
                <td class="text-center">{{ calculate_percentage($totals['new_female_students'],$totals['new_male_students'] + $totals['new_female_students']) }}%</td>
                <td class="text-center">{{ number_format($totals['graduate_male_students'] + $totals['graduate_female_students']) }}</td>
                <td class="text-center">{{ number_format($totals['graduate_male_students']) }}</td>
                <td class="text-center">{{ number_format($totals['graduate_female_students']) }}</td>
                <td class="text-center">{{ calculate_percentage($totals['graduate_male_students'],$totals['graduate_male_students'] + $totals['graduate_female_students']) }}%</td>
                <td class="text-center">{{ calculate_percentage($totals['graduate_female_students'],$totals['graduate_male_students'] + $totals['graduate_female_students']) }}%</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="16">
                    * CAED: Centro de Atención para Estudiantes con Discapacidad.
                    <br>
                    * Incluye alumnos de modalidades Escolarizado, No Escolarizado y Mixto
                </td>
            </tr>
        </tfoot>
    </table>
    @include('layouts.footer')
@endsection