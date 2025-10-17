import { scales } from "chart.js";

//Esquemas de color
const social=["#007A4D","#00AE42","#80BC00","#A1D653"];
const mujeres=["#510C76","#863399","#8347AD","#AB7BC9"];
const apoyos=["#007481","#00A19B","#62CBC9","#AFE2E3"];
const equipo=["#FF5100","#FF7F30","#FF9D6C","#F7BE"];

const proporcionAlumnosTipoNivelEducativo={
    labels: ["Inicial (Escolarizado)", "Inicial (No escolarizado)", "Especial (CAM)", "Preescolar", "Primaria", "Secundaria", "Media superior", "Superior"],
    datasets: [{
        data: [0.8, 1.2, 0.3, 11.3, 37.1, 18.5, 14.8, 16],
        backgroundColor: social
    }]
};
const docentesTipoNivelEducativo={
    labels: ["Inicial (Escolarizado)", "Inicial (No escolarizado)", "Especial (CAM)", "Preescolar", "Primaria", "Secundaria", "Media superior", "Superior"],
    datasets: [
        {
            label: "Públicas",
            data: [35,694,285,390,2832,7060,4986,2935,5101],
            backgroundColor: social[1]
        },{
            label: "Privadas",
            data: [210,0,7,0,1366,2305,2099,2562,5901],
            backgroundColor: apoyos[1]
        }
    ]
};
const matriculaHistoricaMediaSuperior={
    labels: ["2018-2019","2019-2020","2020-2021","2021-2022","2022-2023","2023-2025"],
    datasets: [
        {
            label: "Total",
            data: [93627,91868,88436,85074,91062,96556,99028],
            backgroundColor: equipo[2],
            borderColor: equipo[0],
            pointStyle: "rectRot"
        },{
            label: "Públicas",
            data: [68879,67655,66346,63382,67044,71489,73130],
            backgroundColor: social[2],
            borderColor: social[0],
            pointStyle: "rect"
        },{
            label: "Privadas",
            data: [24748,24213,22090,21692,24018,25067,25898],
            backgroundColor: apoyos[2],
            borderColor: apoyos[0],
            pointStyle: "circle",
        }
    ]
}

new Chart("ProporcionAlumnosTipoNivelEducativo", {
    type: "pie",
    data: proporcionAlumnosTipoNivelEducativo,
    options: {
        radius: '80%',
        responsive: true,
        plugins: {
            title: {
                display: true,
                text: 'Proporción de alumnos atendidos por tipo o nivel educativo'
            },
            /*
            datalabels: {
                anchor: "end",
                align: "end",
                offset: 40
            }
            */
        }
    }
});

new Chart("DocentesTipoNivelEducativo", {
    type: "bar",
    data: docentesTipoNivelEducativo,
    options: {
        responsive: true,
        plugins: {
            title: {
                display: true,
                text: 'Docentes por tipo o nivel educativo y por sostenimiento'
            },
            datalabels: {
                anchor: "end",
                align: "top",
            }
        }
    }
});

new Chart("MatriculaHistoricaMediaSuperior", {
    type: "line",
    data: matriculaHistoricaMediaSuperior,
    options: {
        responsive: true,
        plugins: {
            title: {
                display: true,
                text: 'Matricula Histórica Media Superior'
            },
            datalabels: {
                anchor: "center",
                align: "top",
                offset: 10,
            }
        }
    }
});