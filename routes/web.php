<?php

use Illuminate\Support\Facades\Route;

// Controladores de estadísticas generales
use App\Http\Controllers\StatisticsController18;
use App\Http\Controllers\StatisticsController19;
use App\Http\Controllers\StatisticsController20;
use App\Http\Controllers\StatisticsController21;
use App\Http\Controllers\StatisticsController22;
use App\Http\Controllers\StatisticsController23;
use App\Http\Controllers\StatisticsController24;

// Controladores de estadísticas de media superior
use App\Http\Controllers\HighSchoolStatisticsController18;
use App\Http\Controllers\HighSchoolStatisticsController19;
use App\Http\Controllers\HighSchoolStatisticsController20;
use App\Http\Controllers\HighSchoolStatisticsController21;
use App\Http\Controllers\HighSchoolStatisticsController22;
use App\Http\Controllers\HighSchoolStatisticsController23;
use App\Http\Controllers\HighSchoolStatisticsController24;

// Controlador de estadísticas historicas
use App\Http\Controllers\HistoricalStatisticsController;

// Pagina de bienvenida
Route::get('/', function(){return view('welcome');})->name('welcome-page');

$statisticsControllers = [
    18 => StatisticsController18::class,
    19 => StatisticsController19::class,
    20 => StatisticsController20::class,
    21 => StatisticsController21::class,
    22 => StatisticsController22::class,
    23 => StatisticsController23::class,
    24 => StatisticsController24::class,
];

$highSchoolStatisticsControllers = [
    18 => HighSchoolStatisticsController18::class,
    19 => HighSchoolStatisticsController19::class,
    20 => HighSchoolStatisticsController20::class,
    21 => HighSchoolStatisticsController21::class,
    22 => HighSchoolStatisticsController22::class,
    23 => HighSchoolStatisticsController23::class,
    24 => HighSchoolStatisticsController24::class,
];

// Estadísticas 2021
for ($i= 18; $i < 24; $i++){
    Route::get('/alumnos-y-profesores-por-genero-20'.$i.'-20'.$i+1, [$statisticsControllers[$i], "students_teachers_gender"])->name('apg'.$i.'-'.$i+1);
    Route::get('/alumnos-atendidos-por-tipo-o-nivel-educativo-y-por-sostenimiento-20'.$i.'-20'.$i+1, [$statisticsControllers[$i], "students_school_level_sustenance"])->name('atnes'.$i.'-'.$i+1);
    Route::get('/docentes-por-tipo-o-nivel-educativo-y-por-sostenimiento-20'.$i.'-20'.$i+1, [$statisticsControllers[$i], "teachers_school_level_sustenance"])->name('dtnes'.$i.'-'.$i+1);
    Route::get('/escuelas-por-tipo-o-nivel-educativo-y-por-sostenimiento-20'.$i.'-20'.$i+1, [$statisticsControllers[$i], "schools_school_level_sustenance"])->name('etnes'.$i.'-'.$i+1);
    Route::get('/proporción-de-alumnos-atendidos-por-tipo-o-nivel-educativo-20'.$i.'-20'.$i+1, [$statisticsControllers[$i], "students_school_level_ratio"])->name('patne'.$i.'-'.$i+1);
    Route::get('/alumnos-por-tipo-de-bachillerato-20'.$i.'-20'.$i+1, [$statisticsControllers[$i],'students_high_school_type'])->name('atb'.$i.'-'.$i+1);
    Route::get('/educacion-media-superior-por-tipo-de-sostenimiento-20'.$i.'-20'.$i+ 1,[$statisticsControllers[$i],'high_schools_subcontrol'])->name('emsts'.$i.'-'.$i+1);
    Route::get('alumnos-por-subsistema-en-educación-media-superior-20'.$i.'-20'.$i+ 1,[$highSchoolStatisticsControllers[$i],'students_subsystems'])->name('asems'.$i.'-'.$i+ 1);
    Route::get('docentes-por-subsistema-en-educación-media-superior-20'.$i.'-20'.$i+ 1,[$highSchoolStatisticsControllers[$i],'teachers_subsystems'])->name('dsems'.$i.'-'.$i+ 1);
    Route::get('planteles-por-subsistema-en-educación-media-superior-20'.$i.'-20'.$i+ 1,[$highSchoolStatisticsControllers[$i],'schools_subsystems'])->name('psems'.$i.'-'.$i+ 1);
    Route::get('/alumnos-de-educacion-superior-por-nivel-o-grado-20'.$i.'-20'.$i+1, [$statisticsControllers[$i],'university_students_level_degree'])->name('aesng'.$i.'-'.$i+1);
    Route::get('/alumnos-de-tsu-y-licenciatura-20'.$i.'-20'.$i+1, [$statisticsControllers[$i], "tsu_lic_students"])->name('atl'.$i.'-'.$i+1);
    Route::get('/alumnos-de-posgrado-20'.$i.'-20'.$i+1, [$statisticsControllers[$i], "pos_students"])->name('ap'.$i.'-'.$i+1);
    Route::get('/carreras-de-educacion-superior-20'.$i.'-20'.$i+ 1,[$statisticsControllers[$i],'university_study_programs'])->name('ces'.$i.'-'.$i+ 1);
    Route::get('/carreras-de-tsu-y-licenciaturas-20'.$i.'-20'.$i+ 1,[$statisticsControllers[$i],'tsu_lic_study_programs'])->name('ctl'.$i.'-'.$i+ 1);
    Route::get('/programas-de-posgrado-20'.$i.'-20'.$i+ 1,[$statisticsControllers[$i],'pos_study_programs'])->name('pp'.$i.'-'.$i+ 1);
    Route::get('/educacion-superior-por-tipo-de-sostenimiento-20'.$i.'-20'.$i+ 1,[$statisticsControllers[$i],'universities_subcontrol'])->name('ests'.$i.'-'.$i+1);
    Route::get('/data-table-20'.$i.'-20'.$i+1, [$statisticsControllers[$i],'dataTable']);
    Route::get('/data-debug-20'.$i.'-20'.$i+1, [$statisticsControllers[$i], "retrieveStatistics"]);
}
Route::get('/sample-charts-2021-2022', [StatisticsController21::class, "sample_charts"]);

// Estadísticas historícas
Route::get('/historico', [HistoricalStatisticsController::class, "index"]);

Route::get('/laravel-welcome', function () {
    return view('laravel-welcome');
});