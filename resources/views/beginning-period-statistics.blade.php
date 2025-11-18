@extends('layouts.app')

@vite(['resources/css/tables.css','resources/js/chart.js','resources/css/charts.css'])

@php
    $route=request()->route()->uri();
    $period=implode('/',array_slice(explode('/',$route),0,1));
@endphp

@section('title', 'Estadística de inicio de ciclo escolar '.$period)

@section('content')
    <center>
        <h2>Estadística de inicio de ciclo escolar {{ $period }}</h2>
    </center>
    <table class="table table-bordered border-black mt-4 m-auto w-auto qro-table-header align-middle">
        <thead class="text-center align-middle">
            <tr>
                <th rowspan="2">Tipo educativo</th>
                <th colspan="3">Escuelas</th>
                <th colspan="3">Alumnos</th>
                <th colspan="3">Docentes</th>
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
            @foreach ($basic_ini_statistics as $level => $controls)
                <tr>
                    @if ($level=="Especial (USAER)")
                        <td>{{ $level }} *</td>
                    @else
                        <td>{{ $level }}</td>
                    @endif
                    @php
                        $students_total=0;
                        $teachers_total=0;
                        $schools_total=0;
                        foreach ($controls as $control => $data) {
                            $students_total+=$data['male_students'] + $data['female_students'];
                            $teachers_total+=$data['male_teachers'] + $data['female_teachers'];
                            $schools_total+=$data['school_count'];
                        }
                    @endphp
                    <td class="text-center">{{ number_format($schools_total) }}</td>
                    @foreach ($controls as $control => $data)
                        <td class="text-center">{{ number_format($data['school_count']) }}</td>
                    @endforeach
                    <td class="text-center">{{ number_format($students_total) }}</td>
                    @foreach ($controls as $control => $data)
                        <td class="text-center">{{ number_format($data['male_students'] + $data['female_students']) }}</td>
                    @endforeach
                    <td class="text-center">{{ number_format($teachers_total) }}</td>
                    @foreach ($controls as $control => $data)
                        <td class="text-center">{{ number_format($data['male_teachers'] + $data['female_teachers']) }}</td>
                    @endforeach
                </tr>
            @endforeach
            <tr class="important-row">
                <td>Total Básica</td>
                @php
                    $students_total=0;
                    $teachers_total=0;
                    $schools_total=0;
                    foreach ($basic_ini_totals as $control => $data) {
                        $students_total+=$data['male_students'] + $data['female_students'];
                        $teachers_total+=$data['male_teachers'] + $data['female_teachers'];
                        $schools_total+=$data['school_count'];
                    }
                @endphp
                <td class="text-center">{{ number_format($schools_total) }}</td>
                @foreach ($basic_ini_totals as $control => $data)
                    <td class="text-center">{{ number_format($data['school_count']) }}</td>
                @endforeach
                <td class="text-center">{{ number_format($students_total) }}</td>
                @foreach ($basic_ini_totals as $control => $data)
                    <td class="text-center">{{ number_format($data['male_students'] + $data['female_students']) }}</td>
                @endforeach
                <td class="text-center">{{ number_format($teachers_total) }}</td>
                @foreach ($basic_ini_totals as $control => $data)
                    <td class="text-center">{{ number_format($data['male_teachers'] + $data['female_teachers']) }}</td>
                @endforeach
            </tr>
            <tr class="important-row">
                <td>Total Media Superior **</td>
                @php
                    $students_total=0;
                    $teachers_total=0;
                    $schools_total=0;
                    foreach ($high_school_totals as $control => $data) {
                        $students_total+=$data['male_students'] + $data['female_students'];
                        $teachers_total+=$data['male_teachers'] + $data['female_teachers'];
                        $schools_total+=$data['school_count'];
                    }
                @endphp
                <td class="text-center">{{ number_format($schools_total) }}</td>
                @foreach ($high_school_totals as $control => $data)
                    <td class="text-center">{{ number_format($data['school_count']) }}</td>
                @endforeach
                <td class="text-center">{{ number_format($students_total) }}</td>
                @foreach ($high_school_totals as $control => $data)
                    <td class="text-center">{{ number_format($data['male_students'] + $data['female_students']) }}</td>
                @endforeach
                <td class="text-center">{{ number_format($teachers_total) }}</td>
                @foreach ($high_school_totals as $control => $data)
                    <td class="text-center">{{ number_format($data['male_teachers'] + $data['female_teachers']) }}</td>
                @endforeach
            </tr>
            @foreach ($university_statistics as $type => $controls)
                @if ($type!="Escuelas")
                    <tr>
                        <td>{{ $type }}</td>
                        @php
                            $students_total=0;
                            $teachers_total=0;
                            $schools_total=0;
                            foreach ($controls as $control => $data) {
                                $students_total+=$data['male_students'] + $data['female_students'];
                                $teachers_total+=$data['male_teachers'] + $data['female_teachers'];
                                $schools_total+=$data['school_count'];
                            }
                        @endphp
                        <td class="text-center">{{ number_format($schools_total) }}</td>
                        @foreach ($controls as $control => $data)
                            <td class="text-center">{{ number_format($data['school_count']) }}</td>
                        @endforeach
                        <td class="text-center">{{ number_format($students_total) }}</td>
                        @foreach ($controls as $control => $data)
                            <td class="text-center">{{ number_format($data['male_students'] + $data['female_students']) }}</td>
                        @endforeach
                        <td class="text-center">{{ number_format($teachers_total) }}</td>
                        @foreach ($controls as $control => $data)
                            <td class="text-center">{{ number_format($data['male_teachers'] + $data['female_teachers']) }}</td>
                        @endforeach
                    </tr>
                @endif
            @endforeach
            <tr class="important-row">
                <td>Total Superior **</td>
                @php
                    $students_total=0;
                    $teachers_total=0;
                    $schools_total=0;
                    foreach ($university_totals as $control => $data) {
                        $students_total+=$data['male_students'] + $data['female_students'];
                        $teachers_total+=$data['male_teachers'] + $data['female_teachers'];
                        $schools_total+=$data['school_count'];
                    }
                @endphp
                <td class="text-center">{{ number_format($schools_total) }}</td>
                @foreach ($university_totals as $control => $data)
                    <td class="text-center">{{ number_format($data['school_count']) }}</td>
                @endforeach
                <td class="text-center">{{ number_format($students_total) }}</td>
                @foreach ($university_totals as $control => $data)
                    <td class="text-center">{{ number_format($data['male_students'] + $data['female_students']) }}</td>
                @endforeach
                <td class="text-center">{{ number_format($teachers_total) }}</td>
                @foreach ($university_totals as $control => $data)
                    <td class="text-center">{{ number_format($data['male_teachers'] + $data['female_teachers']) }}</td>
                @endforeach
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="10">
                    * Los datos de alumnos y escuelas de los servicios USAER no se suman en básica debido a que corresponden a servicios y no a escuelas por lo que los alumnos ya están cuantificados en su respectiva escuela.   
                    <br>
                    **  En el total de Escuelas de Media Superior se cuantifican planteles y en Superior se cuantifican instituciones.
                    <br>
                    *** Los datos de las escuelas y docentes en Superior no se suman debido que algunas instituciones imparten Licenciatura y Posgrado.
                </td>
            </tr>
        </tfoot>
    </table>
@endsection