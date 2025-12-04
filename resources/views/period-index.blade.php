@extends('layouts.app')

@section('title','Páginas de estadísticas ('.$period.')')

@php
    function routeKey($name) {
        return implode('.',array_slice(explode('.',$name),1));
    }
    function routeTitle($routeKey,$period):?string {
        switch ($routeKey) {
            case 'eic':
                return 'Estadística de inicio de ciclo';
            case 'apg':
                return 'Alumnos y docentes por género';
            case 'atnes':
                return 'Alumnos atendidos por tipo o nivel educativo y por sostenimiento';
            case 'dtnes':
                return 'Docentes por tipo o nivel educativo y por sostenimiento';
            case 'etnes':
                return 'Escuelas por tipo o nivel educativo y por sostenimiento';
            case 'patne':
                return 'Proporción de alumnos atendidos por tipo o nivel educativo';
            case 'ini':
                return 'Inicial (Escolarizado)';
            case 'ine':
                return 'Inicial (No Escolarizado)';
            case 'cam':
                return 'Especial (CAM)';
            case 'usaer':
                return 'Especial (USAER)';
            case 'pre':
                return 'Preescolar';
            case 'pri':
                return 'Primaria';
            case 'sec':
                return 'Secundaria';
            case 'ms':
                return 'Educación Media Superior';
            case 'ms.atb':
                return 'Alumnos inscritos por tipo de bachillerato';
            case 'ms.ts':
                return 'Planteles y matrícula por tipo de sostenimiento en educación Media Superior';
            case 'ms.ms':
                return 'Matrícula en Media Superior por Subsistema';
            case 'ms.ds':
                return 'Docentes en Media Superior por Subsistema';
            case 'ms.ps':
                return 'Planteles por Subsistema en Educación Media Superior';
            case 'ms.anies':
                return 'Alumnos, Alumnos de Nuevo Ingreso y Egresados por Subsistemas';
            case 'sup':
                return 'Educación Superior';
            case 'sup.ang':
                return 'Matrícula de educación superior por nivel o grado';
            case 'sup.atl':
                return 'Matrícula de educación superior (TSU y Licenciatura)';
            case 'sup.ap':
                return 'Matrícula en posgrado por nivel o grado';
            case 'sup.c':
                return 'Carreras de educación superior';
            case 'sup.ctl':
                return 'Carreras de TSU y Licenciaturas';
            case 'sup.cpp':
                return 'Carreras / Programas de posgrado';
            case 'sup.ts':
                return 'Instituciones y matrícula por tipo de sostenimiento';
            case 'sup.caniecftl':
                return 'Carreras, matrículas, nuevo ingreso y egreso por campo de formación de TSU y Licenciatura';
            case 'sup.caniecfp':
                return 'Carreras, matrículas, nuevo ingreso y egreso por campo de formación de Posgrado';
            case 'sup.imm':
                return 'Instituciones con mayor matrícula en Superior';
            case 'sup.immtl':
                return 'Instituciones con mayor matrícula en Superior (TSU y Licenciatura)';
            case 'sup.immp':
                return 'Instituciones con mayor matrícula en Superior (Posgrado)';
            default:
                if(str_ends_with($routeKey,'ft')){
                    return routeTitle(substr($routeKey,0,-2),$period).' - Federal Transferido';
                } else {
                    return null;
                }
        }
    }
    $iterations=0;
@endphp

@section('content')
    <h1>Páginas de estadísticas ({{ $period }})</h1>
    <h2>Estadísticas generales</h2>
    @foreach ($routes as $route)
        @php
            $key = routeKey($route['name']);
            $title = routeTitle($key,$period);
        @endphp
        @if ($key)
            @if ($key!="index")
                @if ($title == "Inicial (Escolarizado)")
                    <h2>Estadísticas por niveles educativos</h2>
                    <a href="/{{ $route['uri'] }}"><h3>{{ $title }}</h3></a>
                @elseif($title == "Inicial (No Escolarizado)" || $title == "Especial (CAM)" || $title == "Especial (USAER)" || $title == "Preescolar" || $title == "Primaria" || $title == "Secundaria" || $title == "Educación Media Superior" || $title == "Educación Superior")
                    <a href="/{{ $route['uri'] }}"><h3>{{ $title }}</h3></a>
                @else
                    <a href="/{{ $route['uri'] }}">{{ $title }}</a><br>
                @endif
            @endif
        @else
            @if ($iterations==0)
                <h2>Otros</h2>
                @php
                    $iterations++
                @endphp
            @endif
            <a href="/{{ $route['uri'] }}">{{ $route['uri'] }}</a>
            <br>
        @endif
    @endforeach
@endsection