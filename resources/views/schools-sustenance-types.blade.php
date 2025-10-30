@extends('layouts.app')



@section('title', $title)

@vite(['resources/css/tables.css','resources/js/chart.js','resources/css/charts.css'])

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
@endphp

@section(section: 'content')
    <center>
        <h2>{{ $title }}</h2>
    </center>
    <div class="position-absolute start-50 translate-middle-x container">
        <div class="row">
            <div class="col">
                <p>Total {{ $campusesOrInstitutions }}*: {{ number_format($schools) }}</p>
                <canvas id="schools_sustenance" class="stacked-bar-chart my-4"></canvas>
                <canvas id="schools_sustenance_ratio" class="my-4"></canvas>
            </div>
            <div class="col">
                <center>
                    <h2></h2>
                </center>
                <p>Total alumnos: {{ number_format($students) }}</p>
                <canvas id="students_school_sustenance" class="stacked-bar-chart my-4"></canvas>
                <canvas id="students_school_sustenance_ratio" class="my-4"></canvas>
            </div>
        </div>
        <div class="row">
            * En el total de Escuelas de {{ $level }} se cuantifican {{ $campusesOrInstitutions }}.<br>
            @if ($level=="Superior")
                
                ** Incluye TSU, Licenciatura y Posgrado. <br>
                *** Incluye alumnos de modalidades Escolarizado, No Escolarizado y Mixto.
            @endif
            @if ($level=="Media Superior")
                 ** Incluye alumnos de modalidades Escolarizado, No Escolarizado y Mixto. <br>
            @endif
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

        const s1 = new Chart("students_school_sustenance", {
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

        new Chart("schools_sustenance", {
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

        new Chart("schools_sustenance_ratio", {
            type: "pie",
            data: schools_sustenance_ratio,
            options: {
                radius: '60%',
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

        new Chart("students_school_sustenance_ratio", {
            type: "pie",
            data: students_school_sustenance_ratio,
            options: {
                radius: '60%',
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
    </script>
@endsection