@extends('layouts.app')

@vite(['resources/js/charts.js','resources/css/charts.css', 'resources/js/graficos.js'])
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoeqMV/TJlSKda6FXzoEyYGjTe+vXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

@switch($level)
    @case("Media Superior")
        @vite(['resources/css/high-school-tables.css'])
        @break
    @case("Superior")
        @vite(['resources/css/university-tables.css'])
        @break
    @default
        @vite(['resources/css/tables.css'])
@endswitch

@php
    function calculate_percentage($number,$total){
        if($number==0 && $total==0) return 0;
        return round(($number / $total) * 100, 2);
    }
    $route=request()->route()->uri();
    $period=implode('/',array_slice(explode('/',$route),0,1));
@endphp

@section('title','Estadísticas de '.$level.' ('.$period.')')

@section('content')
    <h2 class="text-center">Estadísticas de {{ $level }} ({{ $period }})</h2>
        @if ($level=="Superior")
            <div>
                <h3 class="text-center">**La suma de profesores ya esta realiza, dividirlos por nivel no se puede porque existe el riesgo de duplicidad**</h3>
            </div>
        @endif
    <h3 class="text-center mt-4">Por control</h3>
    <div class="text-center my-3">
        <button class="btn boton-descarga descargar-tabla-btn" 
                data-target-id="porControl" 
                data-filename="Estadisticas-por-control-{{$level}}-{{$period}}.png">Descargar tabla</button>
    </div>
    <div class="table-responsive">
        <table id="porControl" class="table table-bordered border-black my-4 m-auto w-auto qro-table-header align-middle">
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
            <tr class="important-row">
                <td>{{ $level }}</td>
                @php
                    $students_total=0;
                    $teachers_total=0;
                    $schools_total=0;
                    foreach ($totals1 as $control => $data) {
                        $students_total+=$data['male_students'] + $data['female_students'];
                        $teachers_total+=$data['male_teachers'] + $data['female_teachers'];
                        $schools_total+=$data['school_count'];
                    }
                @endphp
                <td class="text-center important-col">
                    {{ number_format($students_total) }}
                    <br>
                    {{ calculate_percentage($students_total,$students_total) }}%
                </td>
                @foreach ($totals1 as $control => $data)
                    <td class="text-center important-col">
                        {{ number_format($data['male_students'] + $data['female_students']) }}
                        <br>
                        {{ calculate_percentage($data['male_students'] + $data['female_students'],$students_total) }}%
                    </td>
                @endforeach
                <td class="text-center important-col">
                    {{ number_format($teachers_total) }}
                    <br>
                    {{ calculate_percentage($teachers_total,$teachers_total) }}%
                </td>
                @foreach ($totals1 as $control => $data)
                    <td class="text-center important-col">
                        {{ number_format($data['male_teachers'] + $data['female_teachers']) }}
                        <br>
                        {{ calculate_percentage($data['male_teachers'] + $data['female_teachers'],$teachers_total) }}%
                    </td>
                @endforeach
                <td class="text-center important-col">
                    {{ number_format($schools_total) }}
                    <br>
                    {{ calculate_percentage($schools_total,$schools_total) }}%
                </td>
                @foreach ($totals1 as $control => $data)
                    <td class="text-center important-col">
                        {{ number_format($data['school_count']) }}
                        <br>
                        {{ calculate_percentage($data['school_count'],$schools_total) }}%
                    </td>
                @endforeach
            </tr>
            @foreach ($stats1 as $type => $controls)
                @if($type!="total")
                    <tr>
                        <td>{{ $type }}</td>
                        @php
                            $students=0;
                            $teachers=0;
                            $schools=0;
                            foreach ($controls as $control => $data) {
                                $students+=$data['male_students'] + $data['female_students'];
                                $teachers+=$data['male_teachers'] + $data['female_teachers'];
                                $schools+=$data['school_count'];
                            }
                        @endphp
                        <td class="text-center important-col">
                            {{ number_format($students) }}
                            <br>
                            {{ calculate_percentage($students,$students_total) }}%
                        </td>
                        @foreach ($controls as $control => $data)
                            <td class="text-center">
                                {{ number_format($data['male_students'] + $data['female_students']) }}
                                <br>
                                {{ calculate_percentage($data['male_students'] + $data['female_students'],$students) }}%
                            </td>
                        @endforeach
                        <td class="text-center important-col">
                            {{ number_format($teachers) }}
                            <br>
                            {{ calculate_percentage($teachers,$teachers_total) }}%
                        </td>
                        @foreach ($controls as $control => $data)
                            <td class="text-center">
                                {{ number_format($data['male_teachers'] + $data['female_teachers']) }}
                                <br>
                                {{ calculate_percentage($data['male_teachers'] + $data['female_teachers'],$teachers) }}%
                            </td>
                        @endforeach
                        <td class="text-center important-col">
                            {{ number_format($schools) }}
                            <br>
                            {{ calculate_percentage($schools,$schools_total) }}%
                        </td>
                        @foreach ($controls as $control => $data)
                            <td class="text-center">
                                {{ number_format($data['school_count']) }}
                                <br>
                                {{ calculate_percentage($data['school_count'],$schools) }}%
                            </td>
                        @endforeach
                    </tr>
                @endif
            @endforeach
        </tbody>
        </table>
    </div>
    <h3 class="text-center mt-4">Alumnos, docentes y escuelas</h3>
    <div class="table-responsive">
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
                @php
                    $students_total=$totals2['male_students'] + $totals2['female_students'];
                    $teachers_total=$totals2['male_teachers'] + $totals2['female_teachers'];
                    $schools_total=$totals2['school_count'];
                @endphp
                <td class="text-center">
                    {{ number_format($students_total) }}
                    <br>
                    {{ calculate_percentage($students_total,$students_total) }}%
                </td>
                <td class="text-center important-col">
                    {{ number_format($totals2['male_students']) }}
                    <br>
                    {{ calculate_percentage($totals2['male_students'],$students_total) }}%
                </td>
                <td class="text-center important-col">
                    {{ number_format($totals2['female_students']) }}
                    <br>
                    {{ calculate_percentage($totals2['female_students'],$students_total) }}%
                </td>
                <td class="text-center important-col">
                    {{ number_format($teachers_total) }}
                    <br>
                    {{ calculate_percentage($teachers_total,$teachers_total) }}%
                </td>
                <td class="text-center important-col">
                    {{ number_format($totals2['male_teachers']) }}
                    <br>
                    {{ calculate_percentage($totals2['male_teachers'],$teachers_total) }}%
                </td>
                <td class="text-center important-col">
                    {{ number_format($totals2['female_teachers']) }}
                    <br>
                    {{ calculate_percentage($totals2['female_teachers'],$teachers_total) }}%
                </td>
                <td class="text-center important-col">
                    {{ number_format($schools_total) }}
                    <br>
                    {{ calculate_percentage($schools_total,$schools_total) }}%
                </td>
            </tr>
            @foreach ($stats2 as $type => $data)
                @if($type!="total")
                    <tr>
                        <td>{{ $type }}</td>
                        @php
                            $students=$data['male_students'] + $data['female_students'];
                            $teachers=$data['male_teachers'] + $data['female_teachers'];
                            $schools=$data['school_count'];
                        @endphp
                        <td class="text-center important-col">
                            {{ number_format($students) }}
                            <br>
                            {{ calculate_percentage($students,$students_total) }}%
                        </td>
                        <td class="text-center">
                            {{ number_format($data['male_students']) }}
                            <br>
                            {{ calculate_percentage($data['male_students'],$students) }}%
                        </td>
                        <td class="text-center">
                            {{ number_format($data['female_students']) }}
                            <br>
                            {{ calculate_percentage($data['female_students'],$students) }}%
                        </td>
                        <td class="text-center important-col">
                            {{ number_format($teachers) }}
                            <br>
                            {{ calculate_percentage($teachers,$teachers_total) }}%
                        </td>
                        <td class="text-center">
                            {{ number_format($data['male_teachers']) }}
                            <br>
                            {{ calculate_percentage($data['male_teachers'],$teachers) }}%
                        </td>
                        <td class="text-center">
                            {{ number_format($data['female_teachers']) }}
                            <br>
                            {{ calculate_percentage($data['female_teachers'],$teachers) }}%
                        </td>
                        <td class="text-center important-col">
                            {{ number_format($schools) }}
                            <br>
                            {{ calculate_percentage($schools,$schools_total) }}%
                        </td>
                    </tr>
                @endif
            @endforeach
        </tbody>
        </table>
    </div>
    <h3 class="text-center mt-4">Por municipios</h3>
    <div class="text-center my-3">
        <button class="btn boton-descarga descargar-tabla-btn" 
            data-target-id="PorMunicipios" 
            data-filename="Por-municipios-{{$level}}-{{$period}}.png">Descargar tabla</button>
    </div>
    <div class="table-responsive">
        <table id="PorMunicipios" class="table table-bordered border-black my-4 m-auto w-auto qro-table-header align-middle">
            <thead class="text-center align-middle">
            <tr>
                <th rowspan="2">Nivel / Municipio</th>
                <th colspan="3">Alumnos</th>
                @if ($level=="Superior" || $level=="Media Superior")
                    @if ($level=="Superior")
                    <th colspan="3">Docentes *</th>
                    <th colspan="3">Escuelas **</th>
                    <th colspan="3">Escuelas/instituciones **</th>
                    @else
                    <th colspan="3">Docentes *</th>
                    <th rowspan="2">grupos</th>
                    <th rowspan="2">aulas</th>
                    <th colspan="3">Escuelas **</th>
                    @endif
                @else
                    <th colspan="3">Docentes</th>
                    <th rowspan="2">grupos</th>
                    <th rowspan="2">aulas</th>
                    <th colspan="3">Escuelas</th>
                @endif
                
            </tr>
            <tr>
                @if ($level=="Superior")
                    <th>Total</th>
                    <th>Hombres</th>
                    <th>Mujeres</th>
                    <th>Total</th>
                    <th>Hombres</th>
                    <th>Mujeres</th>
                    <th>Total</th>
                    <th>Públicas</th>
                    <th>Privadas</th>
                    <th>Total</th>
                    <th>Públicas</th>
                    <th>Privadas</th>
                @else
                    <th>Total</th>
                    <th>Hombres</th>
                    <th>Mujeres</th>
                    <th>Total</th>
                    <th>Hombres</th>
                    <th>Mujeres</th>
                    <th>Total</th>
                    <th>Públicas</th>
                    <th>Privadas</th>
                @endif
                
            </tr>
        </thead>
        <tbody>
            <!--<tr class="important-row">
                <td>{{ $level }}</td>
                <td class="text-center important-col">{{ number_format($totals2['male_students'] + $totals2['female_students']) }}</td>
                <td class="text-center">{{ number_format($totals2['male_students']) }}</td>
                <td class="text-center">{{ number_format($totals2['female_students']) }}</td>
                <td class="text-center important-col">{{ number_format($totals2['male_teachers'] + $totals2['female_teachers']) }}</td>
                <td class="text-center">{{ number_format($totals2['male_teachers']) }}</td>
                <td class="text-center">{{ number_format($totals2['female_teachers']) }}</td>
                <td class="text-center important-col">{{ number_format($totals2['groups'] ?? 0) }}</td>
                <td class="text-center important-col">{{ number_format($totals2['aulas'] ?? 0) }}</td>
                <td class="text-center ">{{ number_format($totals2['school_count']) }}</td>
                <td class="text-center">{{ number_format($totals1['Público']['school_count']) }}</td>
                <td class="text-center">{{ number_format($totals1['Privado']['school_count']) }}</td>

            </tr>
            @foreach ($stats3 as $municipality => $data)
                @if (($data['male_students']+$data['female_students'])>0)
                    <tr>
                        <td>{{ $municipality }}</td>
                        <td class="text-center important-col">{{ number_format($data['male_students'] + $data['female_students']) }}</td>
                        <td class="text-center">{{ number_format($data['male_students']) }}</td>
                        <td class="text-center">{{ number_format($data['female_students']) }}</td>
                        <td class="text-center important-col">{{ number_format($data['male_teachers'] + $data['female_teachers']) }}</td>
                        <td class="text-center">{{ number_format($data['male_teachers']) }}</td>
                        <td class="text-center">{{ number_format($data['female_teachers']) }}</td>
                        <td class="text-center important-col">{{ number_format($data['groups'] ?? 0) }}</td>
                        <td class="text-center important-col">{{ number_format($data['aulas'] ?? 0) }}</td>
                        <td class="text-center important-col">{{ number_format($data['school_count']) }}</td>
                        <td class="text-center">{{ number_format($stats4[$municipality]['Público']['school_count']) }}</td>
                        <td class="text-center">{{ number_format($stats4[$municipality]['Privado']['school_count']) }}</td>

                    </tr>
                @endif
            @endforeach
                -->

         @if ($level=="Superior")
                <tr class="important-row">
                <td>{{ $level }}</td>
                <td class="text-center important-col">{{ number_format($totals2['male_students'] + $totals2['female_students']) }}</td>
                <td class="text-center">{{ number_format($totals2['male_students']) }}</td>
                <td class="text-center">{{ number_format($totals2['female_students']) }}</td>
                <td class="text-center important-col">{{ number_format($totals2['male_teachers'] + $totals2['female_teachers']) }}</td>
                <td class="text-center">{{ number_format($totals2['male_teachers']) }}</td>
                <td class="text-center">{{ number_format($totals2['female_teachers']) }}</td>
                <td class="text-center ">{{ number_format($totals2['school_count']) }}</td>
                <td class="text-center">{{ number_format($totals1['Público']['school_count']) }}</td>
                <td class="text-center">{{ number_format($totals1['Privado']['school_count']) }}</td>
                <td class="text-center ">{{ number_format($totals2['school_count']) }}</td>
                <td class="text-center">{{ number_format($totals1['Público']['school_count']) }}</td>
                <td class="text-center">{{ number_format($totals1['Privado']['school_count']) }}</td>

            </tr>
            @foreach ($stats3 as $municipality => $data)
                @if (($data['male_students']+$data['female_students'])>0)
                    <tr>
                        <td>{{ $municipality }}</td>
                        <td class="text-center important-col">{{ number_format($data['male_students'] + $data['female_students']) }}</td>
                        <td class="text-center">{{ number_format($data['male_students']) }}</td>
                        <td class="text-center">{{ number_format($data['female_students']) }}</td>
                        <td class="text-center important-col">{{ number_format($data['male_teachers'] + $data['female_teachers']) }}</td>
                        <td class="text-center">{{ number_format($data['male_teachers']) }}</td>
                        <td class="text-center">{{ number_format($data['female_teachers']) }}</td>
                        <td class="text-center important-col">{{ number_format($data['school_count']) }}</td>
                        <td class="text-center">{{ number_format($stats4[$municipality]['Público']['school_count']) }}</td>
                        <td class="text-center">{{ number_format($stats4[$municipality]['Privado']['school_count']) }}</td>
                        <td class="text-center important-col">{{ number_format($data['school_count']) }}</td>
                        <td class="text-center">{{ number_format($stats4[$municipality]['Público']['school_count']) }}</td>
                        <td class="text-center">{{ number_format($stats4[$municipality]['Privado']['school_count']) }}</td>

                    </tr>
                @endif
            @endforeach
         @else
             <tr class="important-row">
                <td>{{ $level }}</td>
                <td class="text-center important-col">{{ number_format($totals2['male_students'] + $totals2['female_students']) }}</td>
                <td class="text-center">{{ number_format($totals2['male_students']) }}</td>
                <td class="text-center">{{ number_format($totals2['female_students']) }}</td>
                <td class="text-center important-col">{{ number_format($totals2['male_teachers'] + $totals2['female_teachers']) }}</td>
                <td class="text-center">{{ number_format($totals2['male_teachers']) }}</td>
                <td class="text-center">{{ number_format($totals2['female_teachers']) }}</td>
                <td class="text-center important-col">{{ number_format($totals2['groups'] ?? 0) }}</td>
                <td class="text-center important-col">{{ number_format($totals2['aulas'] ?? 0) }}</td>
                <td class="text-center ">{{ number_format($totals2['school_count']) }}</td>
                <td class="text-center">{{ number_format($totals1['Público']['school_count']) }}</td>
                <td class="text-center">{{ number_format($totals1['Privado']['school_count']) }}</td>

            </tr>
            @foreach ($stats3 as $municipality => $data)
                @if (($data['male_students']+$data['female_students'])>0)
                    <tr>
                        <td>{{ $municipality }}</td>
                        <td class="text-center important-col">{{ number_format($data['male_students'] + $data['female_students']) }}</td>
                        <td class="text-center">{{ number_format($data['male_students']) }}</td>
                        <td class="text-center">{{ number_format($data['female_students']) }}</td>
                        <td class="text-center important-col">{{ number_format($data['male_teachers'] + $data['female_teachers']) }}</td>
                        <td class="text-center">{{ number_format($data['male_teachers']) }}</td>
                        <td class="text-center">{{ number_format($data['female_teachers']) }}</td>
                        <td class="text-center important-col">{{ number_format($data['groups'] ?? 0) }}</td>
                        <td class="text-center important-col">{{ number_format($data['aulas'] ?? 0) }}</td>
                        <td class="text-center important-col">{{ number_format($data['school_count']) }}</td>
                        <td class="text-center">{{ number_format($stats4[$municipality]['Público']['school_count']) }}</td>
                        <td class="text-center">{{ number_format($stats4[$municipality]['Privado']['school_count']) }}</td>

                    </tr>
                @endif
            @endforeach
         @endif
        </tbody>
        </table>
    </div>
    @if ($level!="Media Superior" && $level!="Superior")
        <div class="text-center mt-4">
            <a href="{{ route(Route::currentRouteName().'ft') }}" class="btn boton-descarga">Ver estadísticas del nivel en Federal Transferido</a>
        </div>
    @endif
@include('layouts.footer')
@endsection