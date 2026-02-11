@extends('layouts.app')

@vite(['resources/css/charts.css'])

@switch($level)
    @case("Media Superior")
        @vite(['resources/js/high-school-charts.js'])
        @break
    @case("Superior")
        @vite(['resources/js/university-charts.js'])
        @break
@endswitch

@php
    $schools=0;
    $students=0;
    foreach($statistics as $sustenancetype=>$data){
        $schools+=$data['school_count'];
        $students+=$data['male_students'] + $data['female_students'];
    }
    $campusesOrInstitutions;
    if($level=="Superior") $campusesOrInstitutions="instituciones";
    if($level=="Media Superior") $campusesOrInstitutions="planteles";
    $route=request()->route()->uri();
    $period=implode('/',array_slice(explode('/',$route),0,1));
@endphp

@section('title', $title.' ('.$period.')')

@section(section: 'content')
    <center>
        <h2>{{ $title }} ({{ $period }})</h2>
    </center>
    <div class="container">
        <div class="row row-cols-2">
            <div class="col">
                <p>Total {{ $campusesOrInstitutions }}*: {{ number_format($schools) }}</p>
                <canvas id="schools_sustenance" class="stacked-bar-chart my-4"></canvas>
                <div class="text-center">
                    <button id="downloadSchoolsSustenanceBtn" class="btn boton-descarga">Descargar gráfica</button>
                </div>
            </div>
            <div class="col">
                <p>Total alumnos: {{ number_format($students) }}</p>
                <canvas id="students_school_sustenance" class="stacked-bar-chart my-4"></canvas>
                <div class="text-center">
                    <button id="downloadStudentsSustenanceBtn" class="btn boton-descarga">Descargar gráfica</button>
                </div>
            </div>
            <div class="col">
                * En el total de Escuelas de {{ $level }} se cuantifican {{ $campusesOrInstitutions }}.<br>
                @switch($level)
                    @case("Superior")
                        ** Incluye TSU, Licenciatura y Posgrado. <br>
                        *** Incluye alumnos de modalidades Escolarizado, No Escolarizado y Mixto.
                        @break
                    @case("Media Superior")
                        ** Incluye alumnos de modalidades Escolarizado, No Escolarizado y Mixto.
                        @break
                @endswitch
            </div>
            <div class="col">
                * En el total de Escuelas de {{ $level }} se cuantifican {{ $campusesOrInstitutions }}.<br>
                @switch($level)
                    @case("Superior")
                        ** Incluye TSU, Licenciatura y Posgrado. <br>
                        *** Incluye alumnos de modalidades Escolarizado, No Escolarizado y Mixto.
                        @break
                    @case("Media Superior")
                        ** Incluye alumnos de modalidades Escolarizado, No Escolarizado y Mixto.
                        @break
                @endswitch
            </div>
        </div>
        <div class="row mt-4">
            <center>
                <h2>{{ $title }} ({{ $period }})</h2>
            </center>
        </div>
        <div class="row row-cols-2">
            <div class="col">
                <p>Total {{ $campusesOrInstitutions }}*: {{ number_format($schools) }}</p>
                <canvas id="schools_sustenance_ratio"></canvas>
                <div class="text-center mt-2">
                    <button id="downloadSchoolsSustenanceRatioBtn" class="btn boton-descarga">Descargar gráfica</button>
                </div>
            </div>
            <div class="col">
                <p>Total alumnos: {{ number_format($students) }}</p>
                <canvas id="students_school_sustenance_ratio"></canvas>
                <div class="text-center mt-2">
                    <button id="downloadStudentsSustenanceRatioBtn" class="btn boton-descarga">Descargar gráfica</button>
                </div>
            </div>
            <div class="col">
                * En el total de Escuelas de {{ $level }} se cuantifican {{ $campusesOrInstitutions }}.<br>
                @switch($level)
                    @case("Superior")
                        ** Incluye TSU, Licenciatura y Posgrado. <br>
                        *** Incluye alumnos de modalidades Escolarizado, No Escolarizado y Mixto.
                        @break
                    @case("Media Superior")
                        ** Incluye alumnos de modalidades Escolarizado, No Escolarizado y Mixto.
                        @break
                @endswitch
            </div>
            <div class="col">
                * En el total de Escuelas de {{ $level }} se cuantifican {{ $campusesOrInstitutions }}.<br>
                @switch($level)
                    @case("Superior")
                        ** Incluye TSU, Licenciatura y Posgrado. <br>
                        *** Incluye alumnos de modalidades Escolarizado, No Escolarizado y Mixto.
                        @break
                    @case("Media Superior")
                        ** Incluye alumnos de modalidades Escolarizado, No Escolarizado y Mixto.
                        @break
                @endswitch
            </div>
        </div>
    </div>
    <script type="module">
        let studentsDatasetsMap=[];
        let schoolsDatasetsMap=[];

        @foreach ($statistics as $sustenancetype=>$data)
            @if ($data['male_students'] > 0 || $data['female_students'] > 0 || $data['school_count'] > 0)
                if(!studentsDatasetsMap["{{ $sustenancetype }}"]) studentsDatasetsMap["{{ $sustenancetype }}"] = [];
                if(!schoolsDatasetsMap["{{ $sustenancetype }}"]) schoolsDatasetsMap["{{ $sustenancetype }}"] = [];
                studentsDatasetsMap["{{ $sustenancetype }}"].push({{ $data['male_students'] + $data['female_students'] }});
                schoolsDatasetsMap["{{ $sustenancetype }}"].push({{ $data['school_count'] }});
            @endif
        @endforeach

        let studentsDatasets=[]

        for (const key in studentsDatasetsMap){
            studentsDatasets.push({
                label: key,
                data: studentsDatasetsMap[key]
            });
        }

        let schoolsDatasets=[]

        for (const key in schoolsDatasetsMap){
            schoolsDatasets.push({
                label: key,
                data: schoolsDatasetsMap[key]
            });
        }
        
        let students_school_sustenance={
            labels: ["Cantidad de alumnos"],
            datasets: studentsDatasets
        }

        let schools_sustenance={
            labels: ["Cantidad de planteles"],
            datasets: schoolsDatasets
        }

        let labels=[]
        let studentsData=[]
        let schoolsData=[]

        @foreach ($statistics as $sustenancetype=>$data)
            @if ($data['male_students'] > 0 || $data['female_students'] > 0 || $data['school_count'] > 0)
                labels.push("{{ $sustenancetype }}");
                studentsData.push({{ $data['male_students'] + $data['female_students'] }});
                schoolsData.push({{ $data['school_count'] }})
            @endif
        @endforeach
        
        let students_school_sustenance_ratio={
            labels: labels,
            datasets: [{
                data: studentsData
            }]
        }

        let schools_sustenance_ratio={
            labels: labels,
            datasets: [{
                data: schoolsData
            }]
        }

        const studentsSchoolSustenanceChart = new Chart("students_school_sustenance", {
            type: "bar",
            data: students_school_sustenance,
            options: {
                responsive: true,
                plugins: {
                    datalabels: {
                        color: "white",
                        anchor: "center",
                        align: "center",
                    }
                },
                scales: {
                    x: {
                        stacked: true
                    },
                    y: {
                        stacked: true,
                        title: {
                            display: true,
                            text: "Cantidad de alumnos",
                            font: {
                                size: 14,
                                weight: 'bold'
                            }
                        }
                    }
                }
            }
        });

        const schoolsSustenanceChart = new Chart("schools_sustenance", {
            type: "bar",
            data: schools_sustenance,
            options: {
                responsive: true,
                plugins: {
                    datalabels: {
                        color: "white",
                        anchor: "center",
                        align: "center",
                    }
                },
                scales: {
                    x: {
                        stacked: true
                    },
                    y: {
                        stacked: true,
                        title: {
                            display: true,
                            text: "Cantidad de {{ $campusesOrInstitutions }}",
                            font: {
                                size: 14,
                                weight: 'bold'
                            }
                        }
                    }
                }
            }
        });

        const schoolsSustenanceRatioChart = new Chart("schools_sustenance_ratio", {
            type: "pie",
            data: schools_sustenance_ratio,
            options: {
                radius: '66%',
                responsive: true,
                plugins: {
                    datalabels: {
                        anchor: "end",
                        align: "top",
                    },
                    legend: {
                        onClick: null
                    }
                }
            }
        });

        const studentsSchoolSustenanceRatioChart = new Chart("students_school_sustenance_ratio", {
            type: "pie",
            data: students_school_sustenance_ratio,
            options: {
                radius: '66%',
                responsive: true,
                plugins: {
                    datalabels: {
                        anchor: "end",
                        align: "top",
                    },
                    legend: {
                        onClick: null
                    }
                }
            }
        });

        document.getElementById('downloadSchoolsSustenanceBtn').addEventListener('click', function () {
            const enlace = document.createElement('a');
            enlace.href = schoolsSustenanceChart.toBase64Image();
            enlace.download = `grafica-{{ $campusesOrInstitutions }}-sostenimiento-{{$period}}.png`;
            enlace.click();
        });

        document.getElementById('downloadStudentsSustenanceBtn').addEventListener('click', function () {
            const enlace = document.createElement('a');
            enlace.href = studentsSchoolSustenanceChart.toBase64Image();
            enlace.download = `grafica-alumnos-sostenimiento-{{ str_replace(' ', '-', $level) }}-{{$period}}.png`;
            enlace.click();
        });

        document.getElementById('downloadSchoolsSustenanceRatioBtn').addEventListener('click', function () {
            const enlace = document.createElement('a');
            enlace.href = schoolsSustenanceRatioChart.toBase64Image();
            enlace.download = `proporcion-{{ $campusesOrInstitutions }}-sostenimiento-{{$period}}.png`;
            enlace.click();
        });

        document.getElementById('downloadStudentsSustenanceRatioBtn').addEventListener('click', function () {
            const enlace = document.createElement('a');
            enlace.href = studentsSchoolSustenanceRatioChart.toBase64Image();
            enlace.download = `proporcion-alumnos-sostenimiento-{{ str_replace(' ', '-', $level) }}-{{$period}}.png`;
            enlace.click();
        });
    </script>
    @include('layouts.footer')
@endsection