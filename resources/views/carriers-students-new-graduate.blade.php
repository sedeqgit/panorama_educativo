@extends('layouts.app')

@vite(['resources/css/tables.css','resources/js/chart.js','resources/css/charts.css'])

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

@section('title','Carreras, matrículas, nuevo ingreso y egreso por campo de formación de '.$type.' ('.$period.')')

@section('content')
    <center>
        <h2>Carreras, matrículas, nuevo ingreso y egreso por campo de formación de {{ $type }} ({{ $period }})</h2>
    </center>
    <table class="table table-bordered border-black my-4 m-auto w-auto qro-table-header align-middle">
        <thead class="text-center align-middle">
            <tr>
                <th rowspan="2">Subsistema</th>
                <th rowspan="2">Carreras</th>
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
                    @php
                        $students=$data['male_students'] + $data['female_students'];
                        $new_students=$data['new_male_students'] + $data['new_female_students'];
                        $graduate_students=$data['graduate_male_students'] + $data['graduate_female_students'];
                    @endphp
                    <td class="text-center">{{ number_format($data['carriers']) }}</td>
                    <td class="text-center">{{ number_format($students) }}</td>
                    <td class="text-center">{{ number_format($data['male_students']) }}</td>
                    <td class="text-center">{{ number_format($data['female_students']) }}</td>
                    <td class="text-center important-column">{{ calculate_percentage($data['male_students'],$students) }}%</td>
                    <td class="text-center important-column">{{ calculate_percentage($data['female_students'],$students) }}%</td>
                    <td class="text-center">{{ number_format($new_students) }}</td>
                    <td class="text-center">{{ number_format($data['new_male_students']) }}</td>
                    <td class="text-center">{{ number_format($data['new_female_students']) }}</td>
                    <td class="text-center important-column">{{ calculate_percentage($data['new_male_students'],$new_students) }}%</td>
                    <td class="text-center important-column">{{ calculate_percentage($data['new_female_students'],$new_students) }}%</td>
                    <td class="text-center">{{ number_format($graduate_students) }}</td>
                    <td class="text-center">{{ number_format($data['graduate_male_students']) }}</td>
                    <td class="text-center">{{ number_format($data['graduate_female_students']) }}</td>
                    <td class="text-center important-column">{{ calculate_percentage($data['graduate_male_students'],$graduate_students) }}%</td>
                    <td class="text-center important-column">{{ calculate_percentage($data['graduate_female_students'],$graduate_students) }}%</td>
                    @php
                        $totals['carriers'] = ($totals['carriers'] ?? 0) + ($data['carriers']);
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
                <td class="text-center">{{ number_format($totals['carriers']) }}</td>
                <td class="text-center">{{ number_format($totals['male_students'] + $totals['female_students']) }}</td>
                <td class="text-center">{{ number_format($totals['male_students']) }}</td>
                <td class="text-center">{{ number_format($totals['female_students']) }}</td>
                <td></td>
                <td></td>
                <td class="text-center">{{ number_format($totals['new_male_students'] + $totals['new_female_students']) }}</td>
                <td class="text-center">{{ number_format($totals['new_male_students']) }}</td>
                <td class="text-center">{{ number_format($totals['new_female_students']) }}</td>
                <td></td>
                <td></td>
                <td class="text-center">{{ number_format($totals['graduate_male_students'] + $totals['graduate_female_students']) }}</td>
                <td class="text-center">{{ number_format($totals['graduate_male_students']) }}</td>
                <td class="text-center">{{ number_format($totals['graduate_female_students']) }}</td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="17">
                    * Incluye  modalidades Escolarizado, No Escolarizado y Mixto
                </td>
            </tr>
        </tfoot>
    </table>
    <center>
        <h3>Porcentaje por campo de formación</h3>
    </center>
    <table class="table table-bordered border-black my-4 m-auto w-auto qro-table-header align-middle">
        <thead class="text-center align-middle">
            <tr>
                <th>Subsistema</th>
                <th>Carreras</th>
                <th>Alumnos</th>
                <th>Nuevo ingreso</th>
                <th>Egresados</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($statistics as $subsystem => $data)
                <tr>
                    <td>{{ $subsystem }}</td>
                    @php
                        $students=$data['male_students'] + $data['female_students'];
                        $new_students=$data['new_male_students'] + $data['new_female_students'];
                        $graduate_students=$data['graduate_male_students'] + $data['graduate_female_students'];
                    @endphp
                    <td class="text-center">{{ calculate_percentage($data['carriers'],$totals['carriers']) }}%</td>
                    <td class="text-center">{{ calculate_percentage($students,$totals['male_students'] + $totals['female_students']) }}%</td>
                    <td class="text-center">{{ calculate_percentage($new_students,$totals['new_male_students'] + $totals['new_female_students']) }}%</td>
                    <td class="text-center">{{ calculate_percentage($graduate_students,$totals['graduate_male_students'] + $totals['graduate_female_students']) }}%</td>
                </tr>
            @endforeach
            <tr class="important-row">
                <td>Totales</td>
                <td class="text-center">{{ calculate_percentage($totals['carriers'],$totals['carriers']) }}%</td>
                <td class="text-center">{{ calculate_percentage($totals['male_students'] + $totals['female_students'],$totals['male_students'] + $totals['female_students']) }}%</td>
                <td class="text-center">{{ calculate_percentage($totals['new_male_students'] + $totals['new_female_students'],$totals['new_male_students'] + $totals['new_female_students']) }}%</td>
                <td class="text-center">{{ calculate_percentage($totals['graduate_male_students'] + $totals['graduate_female_students'],$totals['graduate_male_students'] + $totals['graduate_female_students']) }}%</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5">
                    * Incluye  modalidades Escolarizado, No Escolarizado y Mixto
                </td>
            </tr>
        </tfoot>
@endsection