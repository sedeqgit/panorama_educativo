@extends('layouts.app')

@section('title','Alumnos y docentes por genero')

@vite(['resources/css/tables.css', 'resources/js/chart.js', 'resources/css/charts.css'])

@section('content')
    <center>
        <h2>Alumnos y docentes por genero</h2>
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
                    <td class="text-center">{{ number_format($data['male_students'] + $data['female_students']) }}</td>
                    <td class="text-center">{{ number_format($data['male_students']) }}</td>
                    <td class="text-center">{{ number_format($data['female_students']) }}</td>
                    <td class="text-center">{{ number_format($data['male_teachers'] + $data['female_teachers']) }}</td>
                    <td class="text-center">{{ number_format($data['male_teachers']) }}</td>
                    <td class="text-center">{{ number_format($data['female_teachers']) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="7">
                    @if (isset($statistics["Especial (USAER)"]))
                        * La estadística de alumnos en los servicios USAER no se suma en básica ya que se cuantifica en los niveles correspondientes
                        <br>
                    @endif
                    @if (isset($statistics["Media Superior"]) || isset($statistics["Superior"]))
                        ** Incluye alumnos y docentes de modalidades Escolarizado, No Escolarizado y Mixto
                        <br>
                    @endif
                    @if (isset($statistics["Superior"]))
                        *** Incluye TSU, Licenciatura y Posgrado
                    @endif
                </td>
            </tr>
        </tfoot>
    </table>
    <div class="position-absolute start-50 translate-middle-x mt-4">
        <div class="row">
            <div class="col">
                <input type="radio" name="options" id="students" class="btn-check">
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
                plugins: {
                    datalabels: {
                        anchor: "end",
                        align: "top",
                    }
                }
            }
        });

        radioButtons.forEach(radioButton => {
            radioButton.addEventListener('change', () => {
                let labels=[];
                let datasetsMap=[];
                let datasets=[]
                switch (radioButton.id) {
                    case 'students':
                        @foreach ($statistics as $level=>$data)
                            labels.push("{{ $level }}");
                            if(!datasetsMap["Hombres"]) datasetsMap["Hombres"]=[];
                            if(!datasetsMap["Mujeres"]) datasetsMap["Mujeres"]=[];
                            datasetsMap["Hombres"].push({{ $data['male_students'] }});
                            datasetsMap["Mujeres"].push({{ $data['female_students'] }});
                        @endforeach
                        break;
                    case 'teachers':
                        @foreach ($statistics as $level=>$data)
                            labels.push("{{ $level }}");
                            if(!datasetsMap["Hombres"]) datasetsMap["Hombres"]=[];
                            if(!datasetsMap["Mujeres"]) datasetsMap["Mujeres"]=[];
                            datasetsMap["Hombres"].push({{ $data['male_teachers'] }});
                            datasetsMap["Mujeres"].push({{ $data['female_teachers'] }});
                        @endforeach
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
                chart.update();
            });
        });
    </script>
@endsection