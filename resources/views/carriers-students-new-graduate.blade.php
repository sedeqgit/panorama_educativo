@extends('layouts.app')

@section('title','Carreras, matrículas, nuevo ingreso y egreso por campo de formación de '.$type)

@vite(['resources/css/tables.css','resources/js/chart.js','resources/css/charts.css'])

@php
    $totals=[];
@endphp

@section('content')
    <center>
        <h2>Carreras, matrículas, nuevo ingreso y egreso por campo de formación de {{ $type }}</h2>
    </center>
    <div>
    <table class="table table-bordered border-black mt-4 m-auto w-auto qro-table-header align-middle">
        <thead class="text-center align-middle">
            <tr>
                <th rowspan="2">Subsistema</th>
                <th rowspan="2">Carreras</th>
                <th colspan="3">Alumnos</th>
                <th colspan="3">Nuevo ingreso</th>
                <th colspan="3">Egresados</th>
            </tr>
            <tr>
                <th>Total</th>
                <th>Hombres</th>
                <th>Mujeres</th>
                <th>Total</th>
                <th>Hombres</th>
                <th>Mujeres</th>
                <th>Total</th>
                <th>Hombres</th>
                <th>Mujeres</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($statistics as $subsystem => $data)
                @if ($subsystem!="Abierta")
                    <tr>
                        <td>{{ $subsystem }}</td>
                        <td class="text-center">{{ number_format($data['carriers']) }}</td>
                        <td class="text-center">{{ number_format($data['male_students'] + $data['female_students']) }}</td>
                        <td class="text-center">{{ number_format($data['male_students']) }}</td>
                        <td class="text-center">{{ number_format($data['female_students']) }}</td>
                        <td class="text-center">{{ number_format($data['new_male_students'] + $data['new_female_students']) }}</td>
                        <td class="text-center">{{ number_format($data['new_male_students']) }}</td>
                        <td class="text-center">{{ number_format($data['new_female_students']) }}</td>
                        <td class="text-center">{{ number_format($data['graduate_male_students'] + $data['graduate_female_students']) }}</td>
                        <td class="text-center">{{ number_format($data['graduate_male_students']) }}</td>
                        <td class="text-center">{{ number_format($data['graduate_female_students']) }}</td>
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
                @endif
            @endforeach
            <tr>
                <td>Totales</td>
                <td class="text-center">{{ number_format($totals['carriers']) }}</td>
                <td class="text-center">{{ number_format($totals['male_students'] + $totals['female_students']) }}</td>
                <td class="text-center">{{ number_format($totals['male_students']) }}</td>
                <td class="text-center">{{ number_format($totals['female_students']) }}</td>
                <td class="text-center">{{ number_format($totals['new_male_students'] + $totals['new_female_students']) }}</td>
                <td class="text-center">{{ number_format($totals['new_male_students']) }}</td>
                <td class="text-center">{{ number_format($totals['new_female_students']) }}</td>
                <td class="text-center">{{ number_format($totals['graduate_male_students'] + $totals['graduate_female_students']) }}</td>
                <td class="text-center">{{ number_format($totals['graduate_male_students']) }}</td>
                <td class="text-center">{{ number_format($totals['graduate_female_students']) }}</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="12">
                    * Incluye  modalidades Escolarizado, No Escolarizado y Mixto
                </td>
            </tr>
        </tfoot>
    </table>
@endsection