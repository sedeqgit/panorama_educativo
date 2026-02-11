@extends('layouts.app')

@vite(['resources/css/university-tables.css','resources/js/charts.js','resources/css/charts.css', 'resources/js/graficos.js' ])
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoeqMV/TJlSKda6FXzoEyYGjTe+vXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

@php
    arsort($statistics);
    $totals = [];
    $iterations = 0;
    $others = 0;
    $route=request()->route()->uri();
    $period=implode('/',array_slice(explode('/',$route),0,1));
@endphp

@section('title','Instituciones con mayor matrícula en Superior '.$types.' ('.$period.')')

@section('content')
    <center>
        <h2>Instituciones con mayor matrícula en Superior {{ $types }} ({{ $period }})</h2>
    </center>
    <div class="text-center my-3">
        <button class="btn boton-descarga descargar-tabla-btn" 
                data-target-id="datosTabla" 
                data-filename="Instituciones-con-mayor-matricula-en-Superior-{{ $types }}--{{ $period }}.png">Descargar tabla</button>
    </div>
    <table id="datosTabla" class="table table-bordered border-black my-4 m-auto w-auto qro-table-header align-middle">
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
            <tr class="important-row">
                <td>Otras</td>
                <td class="text-center">Varios</td>
                <td class="text-center">{{ number_format($others) }}</td>
            </tr>
            <tr class="important-row" >
                <td colspan="2">Total</td>
                <td class="text-center">{{ number_format($totals['students']) }}</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3">
                    * Incluye  modalidades Escolarizado, No Escolarizado y Mixto
                </th>
            </tr>
        </tfoot>
    </table>
@include('layouts.footer')
@endsection