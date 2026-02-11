@extends("layouts.app")

@vite(["resources/css/federal.css","resources/js/charts.js","resources/css/charts.css", "resources/js/graficos.js"])
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoeqMV/TJlSKda6FXzoEyYGjTe+vXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

@php
    $route=request()->route()->uri();
    $period=implode('/',array_slice(explode('/',$route),0,1));
@endphp

@section("title","Estadísticas de $level - $subcontrol (".$period.')')

@section("content")
    <center>
        <h2>Estadísticas de {{ $level }} - {{ $subcontrol }} ({{ $period }})</h2>
    </center>
    <center>
        @if ($subcontrol=="Federal Transferido")
            <p>Nota: Todas las instituciones Federales Transferidas son de sostenimiento público</p>
        @endif
    </center>
    
    <center>
        <h3>Alumnos, docentes y escuelas</h3>
    </center>
    <div class="text-center my-3">
        <button class="btn boton-descarga descargar-tabla-btn" 
                data-target-id="ade" 
                data-filename="Alumnos-docentes-y-escuelas-{{$level}}-{{$period}}.png">Descargar tabla</button>
    </div>
    <table id="ade" class="table table-bordered border-black my-4 m-auto w-auto qro-table-header align-middle">
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
            <tr class="important-row">
                <td>{{ $level }}</td>
                <td class="text-center  ">{{ number_format($totals["male_students"] + $totals["female_students"]) }}</td>
                <td class="text-center">{{ number_format($totals["male_students"]) }}</td>
                <td class="text-center">{{ number_format($totals["female_students"]) }}</td>
                <td class="text-center ">{{ number_format($totals["male_teachers"] + $totals["female_teachers"]) }}</td>
                <td class="text-center">{{ number_format($totals["male_teachers"]) }}</td>
                <td class="text-center">{{ number_format($totals["female_teachers"]) }}</td>
                <td class="text-center">{{ number_format($totals["school_count"]) }}</td>
            </tr>
            @foreach ($stats1 as $type => $data)
                @if($type!="total")
                    <tr>
                        <td>{{ $type }}</td>
                        <td class="text-center important-col">{{ number_format($data["male_students"] + $data["female_students"]) }}</td>
                        <td class="text-center">{{ number_format($data["male_students"]) }}</td>
                        <td class="text-center">{{ number_format($data["female_students"]) }}</td>
                        <td class="text-center important-col">{{ number_format($data["male_teachers"] + $data["female_teachers"]) }}</td>
                        <td class="text-center">{{ number_format($data["male_teachers"]) }}</td>
                        <td class="text-center">{{ number_format($data["female_teachers"]) }}</td>
                        <td class="text-center">{{ number_format($data["school_count"]) }}</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
    <center>
        <h3>Por municipios</h3>
    </center>
    <div class="text-center my-3">
        <button class="btn boton-descarga descargar-tabla-btn" 
            data-target-id="PorMunicipios" 
            data-filename="Por-municipios-{{$level}}-{{$period}}.png">Descargar tabla</button>
    </div>
    <table id="PorMunicipios" class="table table-bordered border-black my-4 m-auto w-auto qro-table-header align-middle">
        <thead class="text-center align-middle">
            <tr>
                <th rowspan="2">Nivel / Municipio</th>
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
            <tr class="important-row">
                <td>{{ $level }}</td>
                <td class="text-center">{{ number_format($totals["male_students"] + $totals["female_students"]) }}</td>
                <td class="text-center">{{ number_format($totals["male_students"]) }}</td>
                <td class="text-center">{{ number_format($totals["female_students"]) }}</td>
                <td class="text-center">{{ number_format($totals["male_teachers"] + $totals["female_teachers"]) }}</td>
                <td class="text-center">{{ number_format($totals["male_teachers"]) }}</td>
                <td class="text-center">{{ number_format($totals["female_teachers"]) }}</td>
                <td class="text-center">{{ number_format($totals["school_count"]) }}</td>
            </tr>
            @foreach ($stats2 as $municipality => $data)
                @if (($data["male_students"]+$data["female_students"])>0)
                    <tr>
                        <td>{{ $municipality }}</td>
                        <td class="text-center important-col">{{ number_format($data["male_students"] + $data["female_students"]) }}</td>
                        <td class="text-center">{{ number_format($data["male_students"]) }}</td>
                        <td class="text-center">{{ number_format($data["female_students"]) }}</td>
                        <td class="text-center important-col">{{ number_format($data["male_teachers"] + $data["female_teachers"]) }}</td>
                        <td class="text-center">{{ number_format($data["male_teachers"]) }}</td>
                        <td class="text-center">{{ number_format($data["female_teachers"]) }}</td>
                        <td class="text-center">{{ number_format($data["school_count"]) }}</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
@include('layouts.footer')
@endsection