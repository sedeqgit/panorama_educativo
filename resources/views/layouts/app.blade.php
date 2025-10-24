<!DOCTYPE html>
@php
    $periods=[
        "2018-2019",
        "2020-2021",
        "2021-2022",
        "2022-2023",
        "2023-2024",
        "2024-2025"
    ]
@endphp
<html lang="{{ str_replace("_", "-", app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(["resources/css/app.css", "resources/js/app.js"])
    <title>@yield("title")</title>
</head>
<body>
    <header>
        <nav class="navbar sticky-top navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <img src={{ asset("images/logo.png") }} style="height:50px; margin: 10px;">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a href="{{ route("welcome-page") }}" class="nav-link active">Inicio</a>
                        </li>
                        @foreach (array_reverse($periods) as $period)
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Estadísticas {{ $period }}
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li class="dropdown-submenu">
                                        <a href="#" class="dropdown-item">Estadísticas generales</a>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a href="{{ route("period_{$period}.apg") }}" class="dropdown-item">Alumnos y docentes por género</a>
                                            </li>
                                            <li>
                                                <a href="{{ route("period_{$period}.atnes") }}" class="dropdown-item">Alumnos atendidos por tipo o nivel educativo y por sostenimiento</a>
                                            </li>
                                            <li>
                                                <a href="{{ route("period_{$period}.dtnes") }}" class="dropdown-item">Docentes por tipo o nivel educativo y por sostenimiento</a>
                                            </li>
                                            <li>
                                                <a href="{{ route("period_{$period}.etnes") }}" class="dropdown-item">Escuelas por tipo o nivel educativo y por sostenimiento</a>
                                            </li>
                                            <li>
                                                <a href="{{ route("period_{$period}.patne") }}" class="dropdown-item">Proporción de alumnos atendidos por tipo o nivel educativo</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="dropdown-submenu">
                                        <a href="#" class="dropdown-item">Estadísticas por niveles educativos</a>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a href="{{ route("period_{$period}.ini") }}" class="dropdown-item">Inicial (Escolarizado)</a>
                                            </li>
                                            <li>
                                                <a href="{{ route("period_{$period}.ine") }}" class="dropdown-item">Inicial (No Escolarizado)</a>
                                            </li>
                                            <li>
                                                <a href="{{ route("period_{$period}.cam") }}" class="dropdown-item">Especial (CAM)</a>
                                            </li>
                                            <li>
                                                <a href="{{ route("period_{$period}.usaer") }}" class="dropdown-item">Especial (USAER)</a>
                                            </li>
                                            <li>
                                                <a href="{{ route("period_{$period}.pre") }}" class="dropdown-item">Preescolar</a>
                                            </li>
                                            <li>
                                                <a href="{{ route("period_{$period}.pri") }}" class="dropdown-item">Primaria</a>
                                            </li>
                                            <li>
                                                <a href="{{ route("period_{$period}.sec") }}" class="dropdown-item">Secundaria</a>
                                            </li>
                                            <li class="dropdown-submenu">
                                                <a href="#" class="dropdown-item">Educación Media superior</a>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a href="{{ route("period_{$period}.ms") }}" class="dropdown-item">Estadísticas</a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route("period_{$period}.atb") }}" class="dropdown-item">Alumnos inscritos por tipo de bachillerato</a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route("period_{$period}.emsts") }}" class="dropdown-item">Matrícula y planteles o servicios por tipo de sostenimiento</a>
                                                    </li>
                                                    <li class="dropdown-submenu">
                                                        <a href="#" class="dropdown-item">Subsistemas</a>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <a href="{{ route("period_{$period}.asems") }}" class="dropdown-item">Alumnos</a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route("period_{$period}.dsems") }}" class="dropdown-item">Docentes</a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route("period_{$period}.psems") }}" class="dropdown-item">Planteles</a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route("period_{$period}.aniesems") }}" class="dropdown-item">Alumnos, alumnos de nuevo ingreso y egresados</a>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li class="dropdown-submenu">
                                                <a href="#" class="dropdown-item">Educación Superior</a>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a href="{{ route("period_{$period}.sup") }}" class="dropdown-item">Estadísticas</a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route("period_{$period}.ests") }}" class="dropdown-item">Instituciones y matrícula por tipo de sostenimiento</a>
                                                    </li>
                                                    <li class="dropdown-submenu">
                                                        <a href="#" class="dropdown-item">Matrícula</a>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <a href="{{ route("period_{$period}.aesng") }}" class="dropdown-item">Matrícula por nivel o grado</a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route("period_{$period}.atl") }}" class="dropdown-item">Matrícula de TSU y Licenciatura</a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route("period_{$period}.ap") }}" class="dropdown-item">Matrícula en posgrado</a>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                    <li class="dropdown-submenu">
                                                        <a href="#" class="dropdown-item">Programas</a>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <a href="{{ route("period_{$period}.ces") }}" class="dropdown-item">Carreras de educación superior</a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route("period_{$period}.ctl") }}" class="dropdown-item">Carreras de TSU y Licenciaturas</a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route("period_{$period}.pp") }}" class="dropdown-item">Programas de posgrado</a>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                    <li class="dropdown-submenu">
                                                        <a href="#" class="dropdown-item">Campos de formación</a>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <a href="{{ route("period_{$period}.aniecftl") }}" class="dropdown-item">Carreras, matrículas, nuevo ingreso y egreso por campo de formación de TSU y Licenciatura</a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route("period_{$period}.aniecfp") }}" class="dropdown-item">Carreras, matrículas, nuevo ingreso y egreso por campo de formación de Posgrado</a>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <main>
        @yield("content")
    </main>
    <footer>

    </footer>
</body>
</html>