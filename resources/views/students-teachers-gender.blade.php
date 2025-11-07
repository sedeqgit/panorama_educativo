@extends('layouts.app')

@section('title','Alumnos y docentes por género')

@vite(['resources/css/tables.css', 'resources/js/chart.js', 'resources/css/charts.css'])

@php
    function calculate_percentage($number,$total){
        if($number==0 && $total==0) return 0;
        return round(($number / $total) * 100, 2);
    }
@endphp

@section('content')
    <center>
        <h2>Alumnos y docentes por género</h2>
    </center>
    <div>
    <table class="table table-bordered border-black mt-4 m-auto w-auto qro-table-header align-middle">
        <thead class="text-center align-middle">
            <tr>
                <th rowspan="2">Nivel</th>
                <th colspan="3">Alumnos</th>
                <th colspan="3">Docentes</th>
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
            @foreach ($statistics as $level => $data)
                <tr>
                    @if ($level=="Especial (USAER)")
                        <td>{{ $level }} *</td>
                    @elseif ($level=="Media Superior")
                        <td>{{ $level }} **</td>
                    @elseif ($level=="Superior")
                        <td>{{ $level }} **/***</td>
                    @else
                        <td>{{ $level }}</td>
                    @endif
                    @if ($level!="Especial (USAER)")
                        <td class="text-center">
                            {{ number_format($data['male_students'] + $data['female_students']) }}
                            <br>
                            {{ calculate_percentage($data['male_students'] + $data['female_students'],$totals['male_students'] + $totals['female_students']) }}%
                        </td>
                    @else
                        <td class="text-center">{{ number_format($data['male_students'] + $data['female_students']) }}</td>
                    @endif
                    <td class="text-center">
                        {{ number_format($data['male_students']) }}
                        <br>
                        {{ calculate_percentage($data['male_students'],$data['male_students'] + $data['female_students']) }}%
                    </td>
                    <td class="text-center">
                        {{ number_format($data['female_students']) }}
                        <br>
                        {{ calculate_percentage($data['female_students'],$data['male_students'] + $data['female_students']) }}%
                    </td>
                    <td class="text-center">
                        {{ number_format($data['male_teachers'] + $data['female_teachers']) }}
                        <br>
                        {{ calculate_percentage($data['male_teachers'] + $data['female_teachers'],$totals['male_teachers'] + $totals['female_teachers']) }}%
                    </td>
                    <td class="text-center">
                        {{ number_format($data['male_teachers']) }}
                        <br>
                        {{ calculate_percentage($data['male_teachers'],$data['male_teachers'] + $data['female_teachers']) }}%
                    </td>
                    <td class="text-center">
                        {{ number_format($data['female_teachers']) }}
                        <br>
                        {{ calculate_percentage($data['female_teachers'],$data['male_teachers'] + $data['female_teachers']) }}%
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="7">
                    * La estadística de alumnos en los servicios USAER no se suma en básica ya que se cuantifica en los niveles correspondientes
                    <br>
                    ** Incluye alumnos y docentes de modalidades Escolarizado, No Escolarizado y Mixto
                    <br>
                    *** Incluye TSU, Licenciatura y Posgrado
                </td>
            </tr>
        </tfoot>
    </table>
    <div class="position-absolute start-50 translate-middle-x mt-4">
        <div class="row">
            <div class="col">
                <input type="radio" name="options" id="students" class="btn-check" checked>
                <label class="btn btn-outline-primary" for="students">Alumnos</label>
            </div>
            <div class="col">
                <input type="radio" name="options" id="teachers" class="btn-check">
                <label class="btn btn-outline-primary" for="teachers">Docentes</label>
            </div>
        </div>
        <canvas id="students_teachers_gender" class="bar-chart m-auto"></canvas>
    </div>
    <script type="module">
        const radioButtons=document.querySelectorAll('input[type="radio"]');

        const chart = new Chart("students_teachers_gender", {
            type: "bar",
            options: {
                responsive: true,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: "Nivel educativo",
                            font: {
                                size: 14,
                                weight: 'bold'
                            }
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            font: {
                                size: 14,
                                weight: 'bold'
                            }
                        }
                    }
                },
                plugins: {
                    datalabels: {
                        anchor: "end",
                        align: "top",
                    }
                }
            }
        });

        function update_chart(option){
            let labels=[];
            let datasetsMap=[];
            let datasets=[]
            let yTitle;
            switch (option) {
                case 'students':
                    @foreach ($statistics as $level=>$data)
                        labels.push("{{ $level }}");
                        if(!datasetsMap["Hombres"]) datasetsMap["Hombres"]=[];
                        if(!datasetsMap["Mujeres"]) datasetsMap["Mujeres"]=[];
                        datasetsMap["Hombres"].push({{ $data['male_students'] }});
                        datasetsMap["Mujeres"].push({{ $data['female_students'] }});
                    @endforeach
                    yTitle="Alumnos atendidos"
                    break;
                case 'teachers':
                    @foreach ($statistics as $level=>$data)
                        labels.push("{{ $level }}");
                        if(!datasetsMap["Hombres"]) datasetsMap["Hombres"]=[];
                        if(!datasetsMap["Mujeres"]) datasetsMap["Mujeres"]=[];
                        datasetsMap["Hombres"].push({{ $data['male_teachers'] }});
                        datasetsMap["Mujeres"].push({{ $data['female_teachers'] }});
                    @endforeach
                    yTitle="Cantidad de docentes"
                    break;
            }
            for (const key in datasetsMap){
                datasets.push({
                    label: key,
                    data: datasetsMap[key]
                })
            }
            let students_teachers_gender={
                labels: labels,
                datasets: datasets
            }
            chart.data=students_teachers_gender;
            chart.options.scales.y.title.text=yTitle;
            chart.update();
        }

        update_chart('students');

        radioButtons.forEach(radioButton => {
            radioButton.addEventListener('change', () => update_chart(radioButton.id));
        });
    </script>
@endsection