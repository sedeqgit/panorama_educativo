@extends('layouts.app')

@section('title','Instituciones con mayor matrícula en Superior'.$types)

@vite(['resources/css/tables.css','resources/js/chart.js','resources/css/charts.css'])

@php
    arsort($statistics);
    $totals = [];
    $iterations = 0;
    $others = 0;
@endphp

@section('content')
    <center>
        <h2>Instituciones con mayor matrícula en Superior {{ $types }}</h2>
    </center>
    <table class="table table-bordered border-black my-4 m-auto w-auto qro-table-header align-middle">
        <thead class="text-center align-middle">
            <tr>
                <th>Institución</th>
                <th>Sostenimiento</th>
                <th>Matrícula</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($statistics as $institution => $data)
                <tr>
                    @if ($iterations<=$limit)
                        <td>{{ $institution }}</td>
                        <td class="text-center">{{ $data['sustenance'] }}</td>
                        <td class="text-center">{{ number_format($data['students']) }}</td>
                        @php
                            $iterations++
                        @endphp
                    @else
                        @php
                            $others += $data['students'];
                        @endphp
                    @endif
                    @php
                        $totals['students'] = ($totals['students'] ?? 0) + ($data['students']);
                    @endphp
                </tr>
            @endforeach
            <tr>
                <td>Otras</td>
                <td class="text-center">Varios</td>
                <td class="text-center">{{ number_format($others) }}</td>
            </tr>
            <tr>
                <td colspan="2">Total</td>
                <td class="text-center">{{ number_format($totals['students']) }}</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3">
                    * Incluye  modalidades Escolarizado, No Escolarizado y Mixto
                </td>
            </tr>
        </tfoot>
    </table>
@endsection