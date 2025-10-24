@extends('layouts.app')

@section('title','Estadísticas de '.$level)

@vite(['resources/css/tables.css','resources/js/chart.js','resources/css/charts.css'])

@section('content')
    <center>
        <h2>Estadísticas de {{ $level }}</h2>
    </center>
    <div>
    <table class="table table-bordered border-black mt-4 m-auto w-auto qro-table-header align-middle">
        <thead class="text-center align-middle">
            <tr>
                <th rowspan="2">Tipo educativo</th>
                <th colspan="3">Alumnos</th>
                @if ($level=="Superior" || $level=="Media Superior")
                    <th colspan="3">Docentes *</th>
                    <th colspan="3">Escuelas **</th>
                @else
                    <th colspan="3">Docentes</th>
                    <th colspan="3">Escuelas</th>
                @endif
            </tr>
            <tr>
                <th>Total</th>
                <th>Públicas</th>
                <th>Privadas</th>
                <th>Total</th>
                <th>Públicas</th>
                <th>Privadas</th>
                <th>Total</th>
                <th>Públicas</th>
                <th>Privadas</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $level }}</td>
                <td class="text-center">{{ number_format($stats2['Público']['male_students'] + $stats2['Público']['female_students'] + $stats2['Privado']['male_students'] + $stats2['Privado']['female_students'] ) }}</td>
                <td class="text-center">{{ number_format($stats2['Público']['male_students'] + $stats2['Público']['female_students']) }}</td>
                <td class="text-center">{{ number_format($stats2['Privado']['male_students'] + $stats2['Privado']['female_students']) }}</td>
                <td class="text-center">{{ number_format($stats2['Público']['male_teachers'] + $stats2['Público']['female_teachers'] + $stats2['Privado']['male_teachers'] + $stats2['Privado']['female_teachers']) }}</td>
                <td class="text-center">{{ number_format($stats2['Público']['male_teachers'] + $stats2['Público']['female_teachers']) }}</td>
                <td class="text-center">{{ number_format($stats2['Privado']['male_teachers'] + $stats2['Privado']['female_teachers']) }}</td>
                <td class="text-center">{{ number_format($stats2['Público']['school_count'] + $stats2['Privado']['school_count']) }}</td>
                <td class="text-center">{{ number_format($stats2['Público']['school_count']) }}</td>
                <td class="text-center">{{ number_format($stats2['Privado']['school_count']) }}</td>
            </tr>
            @foreach ($stats1 as $type => $controls)
                @if($type!="total")
                    <tr>
                        <td>{{ $type }}</td>
                        <td class="text-center">{{ number_format($controls['Público']['male_students'] + $controls['Público']['female_students'] + $controls['Privado']['male_students'] + $controls['Privado']['female_students']) }}</td>
                        <td class="text-center">{{ number_format($controls['Público']['male_students'] + $controls['Público']['female_students']) }}</td>
                        <td class="text-center">{{ number_format($controls['Privado']['male_students'] + $controls['Privado']['female_students']) }}</td>
                        <td class="text-center">{{ number_format($controls['Público']['male_teachers'] + $controls['Público']['female_teachers'] + $controls['Privado']['male_teachers'] + $controls['Privado']['female_teachers']) }}</td>
                        <td class="text-center">{{ number_format($controls['Público']['male_teachers'] + $controls['Público']['female_teachers']) }}</td>
                        <td class="text-center">{{ number_format($controls['Privado']['male_teachers'] + $controls['Privado']['female_teachers']) }}</td>
                        <td class="text-center">{{ number_format($controls['Público']['school_count'] + $controls['Privado']['school_count']) }}</td>
                        <td class="text-center">{{ number_format($controls['Público']['school_count']) }}</td>
                        <td class="text-center">{{ number_format($controls['Privado']['school_count']) }}</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
    <table class="table table-bordered border-black mt-4 m-auto w-auto qro-table-header align-middle">
        <thead class="text-center align-middle">
            <tr>
                <th rowspan="2">Tipo educativo</th>
                <th colspan="3">Alumnos</th>
                @if ($level=="Superior" || $level=="Media Superior")
                    <th colspan="3">Docentes *</th>
                    <th rowspan="2">Escuelas **</th>
                @else
                    <th colspan="3">Docentes</th>
                    <th rowspan="2">Escuelas</th>
                @endif
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
            <tr>
                <td>{{ $level }}</td>
                <td class="text-center">{{ number_format($totals['male_students'] + $totals['female_students']) }}</td>
                <td class="text-center">{{ number_format($totals['male_students']) }}</td>
                <td class="text-center">{{ number_format($totals['female_students']) }}</td>
                <td class="text-center">{{ number_format($totals['male_teachers'] + $totals['female_teachers']) }}</td>
                <td class="text-center">{{ number_format($totals['male_teachers']) }}</td>
                <td class="text-center">{{ number_format($totals['female_teachers']) }}</td>
                <td class="text-center">{{ number_format($totals['school_count']) }}</td>
            </tr>
            @foreach ($stats3 as $type => $data)
                @if($type!="total")
                    <tr>
                        <td>{{ $type }}</td>
                        <td class="text-center">{{ number_format($data['male_students'] + $data['female_students']) }}</td>
                        <td class="text-center">{{ number_format($data['male_students']) }}</td>
                        <td class="text-center">{{ number_format($data['female_students']) }}</td>
                        <td class="text-center">{{ number_format($data['male_teachers'] + $data['female_teachers']) }}</td>
                        <td class="text-center">{{ number_format($data['male_teachers']) }}</td>
                        <td class="text-center">{{ number_format($data['female_teachers']) }}</td>
                        <td class="text-center">{{ number_format($data['school_count']) }}</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
@endsection