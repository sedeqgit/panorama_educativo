@extends('layouts.app')

@section('title','Tabla de datos')

@vite(['resources/css/tables.css'])

@section('content')
    <center>
        <h2>Tabla de datos</h2>
    </center>
    <div>
    <table class="table table-bordered border-black mt-4 m-auto w-auto qro-table-header align-middle">
        <thead class="text-center align-middle">
            <tr>
                <th>Municipio</th>
                <th>Nivel</th>
                <th>Tipo</th>
                <th>Control</th>
                <th>Subcontrol</th>
                <th>Escuelas</th>
                <th colspan="2">Alumnos</th>
                <th colspan="2">Docentes</th>
            </tr>
        </thead>
        <tbody>
            @foreach($statistics as $municipality => $levels)
                @foreach($levels as $level => $types)
                    @foreach ($types as $type => $controls)
                        @foreach ($controls as $control => $subcontrols)
                            @foreach ($subcontrols as $subcontrol => $data)
                                <tr>
                                    <td>{{ $municipality }}</td>
                                    <td>{{ $level }}</td>
                                    <td>{{ $type }}</td>
                                    <td>{{ $control }}</td>
                                    <td>{{ $subcontrol }}</td>
                                    <td>{{ number_format($data['school_count']) }}</td>
                                    <td class="text-center">{{ number_format($data['male_students']) }}</td>
                                    <td class="text-center">{{ number_format($data['female_students']) }}</td>
                                    <td class="text-center">{{ number_format($data['male_teachers']) }}</td>
                                    <td class="text-center">{{ number_format($data['female_teachers']) }}</td>
                                </tr>
                            @endforeach
                        @endforeach
                    @endforeach
                @endforeach
            @endforeach
        </tbody>
    </table>

    @include('layouts.footer')
@endsection