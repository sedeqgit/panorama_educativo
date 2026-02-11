<!DOCTYPE html>
@php
    $periods=[
        "2018-2019",
        "2019-2020",
        "2020-2021",
        "2021-2022",
        "2022-2023",
        "2023-2024",
        "2024-2025"
    ];

    $activePeriod = request('periodo', ''); 
@endphp

<html lang="{{ str_replace("_", "-", app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(["resources/css/app.css", "resources/js/app.js"])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>@yield("title")</title>
</head>
<body>
    <header>
    <div class="sticky-top navbar-expand-lg bg-body-tertiary">
        <div class="colorbarra">
            <div class="container clearfix">
                <div class="row justify-content-between align-items-center m-0"> <div class="col-12 col-md-auto p-0">
                        <div class="top-links">
                            <ul class="top-links-container">
                                <li class="top-links-item"><a target="_blank" href="https://www.queretaro.gob.mx/transparencia">PORTAL TRANSPARENCIA</a></li>
                                <li class="top-links-item"><a target="_blank" href="https://portal.queretaro.gob.mx/prensa/">PORTAL PRENSA</a></li>
                                <li class="top-links-item"><a target="_blank" href="https://www.queretaro.gob.mx/covid19">COVID19</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-12 col-md-auto p-0">
                        <ul id="top-social">
                            <li>
                                <a href="https://wa.me/+524421443740">
                                    <span class="ts-icon"><img src="https://www.queretaro.gob.mx/o/queretaro-theme/images/chatboxLines.png" width="20px" height="20px"></span>
                                    <span class="ts-text">Chatbot</span>
                                </a>
                            </li>
                            <li>
                                <a href="https://www.facebook.com/GobQro?fref=ts" target="_blank">
                                    <span class="ts-icon"><i class="fa-brands fa-facebook"></i></span>
                                    <span class="ts-text">Facebook</span>
                                </a>
                            </li>
                            <li>
                                <a href="https://twitter.com/gobqro" target="_blank">
                                    <span class="ts-icon"><i class="fa-brands fa-twitter"></i></span>
                                    <span class="ts-text">Twitter</span>
                                </a>
                            </li>
                            <li>
                                <a href="https://www.instagram.com/gobiernoqueretaro/" target="_blank">
                                    <span class="ts-icon"><i class="fa-brands fa-instagram"></i></span>
                                    <span class="ts-text">Instagram</span>
                                </a>
                            </li>
                            <li>
                                <a href="https://www.youtube.com/user/GobQro" target="_blank">
                                    <span class="ts-icon"><i class="fa-brands fa-youtube"></i></span>
                                    <span class="ts-text">Youtube</span>
                                </a>
                            </li>
                            <li>
                                <a href="tel:4422117070">
                                    <span class="ts-icon"><i class="fa-solid fa-phone"></i></span>
                                    <span class="ts-text">4422117070</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
        <nav class="navbar sticky-top navbar-expand-lg bg-body-tertiary" >
            <div class="container">
                <a class="navbar-brand" href="#"><!--logo-->
                    <img src="{{ asset("images/logo.png") }}" alt="Logo del sitio" class="logo-img">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item "><!--inicio-->
                            <a href="{{ route("welcome-page") }}" class="nav-link">Inicio</a>
                        </li>
                        <li class="nav-item dropdown"><!--ciclos escolares-->
                            <a href="#" class="nav-link " role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Ciclos escolares
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown"><!--despliegue de estadisticas por ciclos-->
                                @foreach ($periods as $p)
                                    <li>
                                        <a href="{{ url()->current() }}?periodo={{ $p }}" class="dropdown-item">
                                            Estadísticas {{ $p }}
                                        </a>
                                    </li><li><hr class="dropdown-divider"></li>
                                @endforeach
                            </ul>
                        </li>
                        @if ($activePeriod != "")
                            <li class="nav-item dropdown">
                                <a class="nav-link active"  aria-expanded="false">
                                    Periodo {{ $activePeriod }}
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link " href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Estadísticas generales 
                                </a>
                                    <ul class="dropdown-menu">
                                            <li>
                                                <a href="{{ route("period_".$activePeriod.".eic") }}" class="dropdown-item">Estadísticas de inicio de ciclo</a>
                                            </li><li><hr class="dropdown-divider"></li>
                                            <li>
                                                <a href="{{ route("period_".$activePeriod.".apg") }}" class="dropdown-item">Alumnos y docentes por género</a>
                                            </li><li><hr class="dropdown-divider"></li>
                                            <li>
                                                <a href="{{ route("period_".$activePeriod.".atnes") }}" class="dropdown-item">Alumnos atendidos por tipo o nivel educativo y por sostenimiento</a>
                                            </li><li><hr class="dropdown-divider"></li>
                                            <li>
                                                <a href="{{ route("period_".$activePeriod.".dtnes") }}" class="dropdown-item">Docentes por tipo o nivel educativo y por sostenimiento</a>
                                            </li><li><hr class="dropdown-divider"></li>
                                            <li>
                                                <a href="{{ route("period_".$activePeriod.".etnes") }}" class="dropdown-item">Escuelas por tipo o nivel educativo y por sostenimiento</a>
                                            </li><li><hr class="dropdown-divider"></li>
                                            <li>
                                                <a href="{{ route("period_".$activePeriod.".patne") }}" class="dropdown-item">Proporción de alumnos atendidos por tipo o nivel educativo</a>
                                            </li>
                                    </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link " href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Educación basica</a>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a href="{{ route("period_".$activePeriod.".ini") }}" class="dropdown-item">Inicial (Escolarizado)</a>
                                            </li><li><hr class="dropdown-divider"></li>
                                            @if ($activePeriod!="2018-2019")
                                                <li>
                                                    <a href="{{ route("period_".$activePeriod.".ine") }}" class="dropdown-item">Inicial (No Escolarizado)</a>
                                                </li><li><hr class="dropdown-divider"></li>
                                            @endif
                                            <li>
                                                <a href="{{ route("period_".$activePeriod.".cam") }}" class="dropdown-item">Especial (CAM)</a>
                                            </li><li><hr class="dropdown-divider"></li>
                                            <li>
                                                <a href="{{ route("period_".$activePeriod.".usaer") }}" class="dropdown-item">Especial (USAER)</a>
                                            </li><li><hr class="dropdown-divider"></li>
                                            <li>
                                                <a href="{{ route("period_".$activePeriod.".pre") }}" class="dropdown-item">Preescolar</a>
                                            </li><li><hr class="dropdown-divider"></li>
                                            <li>
                                                <a href="{{ route("period_".$activePeriod.".pri") }}" class="dropdown-item">Primaria</a>
                                            </li><li><hr class="dropdown-divider"></li>
                                            <li>
                                                <a href="{{ route("period_".$activePeriod.".sec") }}" class="dropdown-item">Secundaria</a>
                                            </li>
                                        </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link " href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Educación Media Superior</a>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a href="{{ route("period_".$activePeriod.".ms") }}" class="dropdown-item">Estadísticas generales</a>
                                                    </li><li><hr class="dropdown-divider"></li>
                                                    <li>
                                                        <a href="{{ route("period_".$activePeriod.".ms.atb") }}" class="dropdown-item">Alumnos inscritos por tipo de bachillerato</a>
                                                    </li><li><hr class="dropdown-divider"></li>
                                                    <li>
                                                        <a href="{{ route("period_".$activePeriod.".ms.ts") }}" class="dropdown-item">Planteles y matrícula por tipo de sostenimiento en educación Media Superior</a>
                                                    </li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li class="dropdown-submenu">
                                                        <a href="#" class="dropdown-item">Subsistemas</a>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <a href="{{ route("period_".$activePeriod.".ms.ms") }}" class="dropdown-item">Matrícula</a>
                                                            </li>
                                                            <li><hr class="dropdown-divider"></li>
                                                            <li>
                                                                <a href="{{ route("period_".$activePeriod.".ms.ds") }}" class="dropdown-item">Docentes</a>
                                                            </li><li><hr class="dropdown-divider"></li>
                                                            <li>
                                                                <a href="{{ route("period_".$activePeriod.".ms.ps") }}" class="dropdown-item">Planteles</a>
                                                            </li><li><hr class="dropdown-divider"></li>
                                                            <li>
                                                                <a href="{{ route("period_".$activePeriod.".ms.anies") }}" class="dropdown-item">Alumnos, alumnos de nuevo ingreso y egresados</a>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Educación Superior</a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="{{ route("period_".$activePeriod.".sup") }}" class="dropdown-item">Estadísticas generales</a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <a href="{{ route("period_".$activePeriod.".sup.ts") }}" class="dropdown-item">Instituciones y matrícula por tipo de sostenimiento</a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li class="dropdown-submenu">
                                            <a href="#" class="dropdown-item">Matrícula</a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a href="{{ route("period_".$activePeriod.".sup.ang") }}" class="dropdown-item">Matrícula por nivel o grado</a>
                                                </li><li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <a href="{{ route("period_".$activePeriod.".sup.atl") }}" class="dropdown-item">Matrícula de TSU y Licenciatura</a>
                                                </li><li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <a href="{{ route("period_".$activePeriod.".sup.ap") }}" class="dropdown-item">Matrícula en posgrado</a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li class="dropdown-submenu">
                                            <a href="#" class="dropdown-item">Carreras / Programas</a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a href="{{ route("period_".$activePeriod.".sup.c") }}" class="dropdown-item">Carreras de educación superior</a>
                                                </li><li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <a href="{{ route("period_".$activePeriod.".sup.ctl") }}" class="dropdown-item">Carreras de TSU y Licenciaturas</a>
                                                </li><li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <a href="{{ route("period_".$activePeriod.".sup.cpp") }}" class="dropdown-item">Carreras / Programas de posgrado</a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li class="dropdown-submenu">
                                            <a href="#" class="dropdown-item">Campos de formación</a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a href="{{ route("period_".$activePeriod.".sup.caniecftl") }}" class="dropdown-item"> Campo de formación de TSU y Licenciatura</a>
                                                </li><li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <a href="{{ route("period_".$activePeriod.".sup.caniecfp") }}" class="dropdown-item"> Campo de formación de Posgrado</a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li class="dropdown-submenu">
                                            <a href="#" class="dropdown-item">Instituciones con mayor matrícula</a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a href="{{ route("period_".$activePeriod.".sup.imm") }}" class="dropdown-item">Todos</a>
                                                </li><li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <a href="{{ route("period_".$activePeriod.".sup.immtl") }}" class="dropdown-item">TSU y Licenciatura</a>
                                                </li><li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <a href="{{ route("period_".$activePeriod.".sup.immp") }}" class="dropdown-item">Posgrado</a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                            </li>
                         @endif
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <main>
        @yield("content")
    </main>
  
</body>

</html>