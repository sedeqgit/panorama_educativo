<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>@yield('title')</title>
</head>
<body>
    <header>
        <nav class="navbar sticky-top navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <img src={{ asset('images/logo.png') }} style="height:50px; margin: 10px;">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a href="{{ route('welcome-page') }}" class="nav-link active">Inicio</a>
                        </li>
                        @for ($i = 21; $i >= 21; $i--)
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Estadísticas 20{{ $i }}-20{{ $i+1 }}
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li>
                                        <a href="{{ route('apg'.$i.'-'.$i+1) }}" class="dropdown-item">Alumnos y profesores por genero</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('atnes'.$i.'-'.$i+1) }}" class="dropdown-item">Alumnos atendidos por tipo o nivel educativo y por sostenimiento</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('dtnes'.$i.'-'.$i+1) }}" class="dropdown-item">Docentes por tipo o nivel educativo y por sostenimiento</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('etnes'.$i.'-'.$i+1) }}" class="dropdown-item">Escuelas por tipo o nivel educativo y por sostenimiento</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('patne'.$i.'-'.$i+1) }}" class="dropdown-item">Proporción de alumnos atendidos por tipo o nivel educativo</a>
                                    </li>
                                    <li class="dropdown-submenu">
                                        <a href="#" class="dropdown-item">Educación Media superior</a>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a href="{{ route('atb'.$i.'-'.$i+1) }}" class="dropdown-item">Alumnos por tipo de bachillerato</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('emsts'.$i.'-'.$i+1) }}" class="dropdown-item">Tipos de sostenimiento</a>
                                            </li>
                                            <li class="dropdown-submenu">
                                                <a href="#" class="dropdown-item">Subsistemas</a>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a href="{{ route('asems'.$i.'-'.$i+1) }}" class="dropdown-item">Alumnos</a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('dsems'.$i.'-'.$i+1) }}" class="dropdown-item">Docentes</a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('psems'.$i.'-'.$i+1) }}" class="dropdown-item">Planteles</a>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="dropdown-submenu">
                                        <a href="#" class="dropdown-item">Educación Superior</a>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a href="{{ route('ests'.$i.'-'.$i+1) }}" class="dropdown-item">Tipos de sostenimiento</a>
                                            </li>
                                            <li class="dropdown-submenu">
                                                <a href="#" class="dropdown-item">Alumnos</a>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a href="{{ route('aesng'.$i.'-'.$i+1) }}" class="dropdown-item">Alumnos por nivel o grado</a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('atl'.$i.'-'.$i+1) }}" class="dropdown-item">Alumnos de TSU y Licenciatura</a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('ap'.$i.'-'.$i+1) }}" class="dropdown-item">Alumnos de posgrado</a>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li class="dropdown-submenu">
                                                <a href="#" class="dropdown-item">Programas</a>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a href="{{ route('ces'.$i.'-'.$i+1) }}" class="dropdown-item">Carreras de educación superior</a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('ctl'.$i.'-'.$i+1) }}" class="dropdown-item">Carreras de TSU y Licenciaturas</a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('pp'.$i.'-'.$i+1) }}" class="dropdown-item">Programas de posgrado</a>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        @endfor
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <main>
        @yield('content')
    </main>
    <footer>

    </footer>
</body>
</html>