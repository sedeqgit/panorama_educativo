<?php

use Illuminate\Support\Facades\Route;

// Controlador de estadísticas historicas
use App\Http\Controllers\HistoricalStatisticsController;

// Pagina de bienvenida
Route::get('/', function(){return view('welcome');})->name('welcome-page');

// Controladores de la estadísticas escolares
$statisticsControllers = [
    '2018-2019' => [
        'general' => App\Http\Controllers\StatisticsController18::class,
        'high_school' => App\Http\Controllers\HighSchoolStatisticsController18::class,
        'university' => App\Http\Controllers\UniversityStatisticsController18::class
    ],
    '2019-2020' => [
        'general' => App\Http\Controllers\StatisticsController19::class,
        'high_school' => App\Http\Controllers\HighSchoolStatisticsController19::class,
        'university' => App\Http\Controllers\UniversityStatisticsController19::class
    ],
    '2020-2021' => [
        'general' => App\Http\Controllers\StatisticsController20::class,
        'high_school' => App\Http\Controllers\HighSchoolStatisticsController20::class,
        'university' => App\Http\Controllers\UniversityStatisticsController20::class
    ],
    '2021-2022' => [
        'general' => App\Http\Controllers\StatisticsController21::class,
        'high_school' => App\Http\Controllers\HighSchoolStatisticsController21::class,
        'university' => App\Http\Controllers\UniversityStatisticsController21::class
    ],
    '2022-2023' => [
        'general' => App\Http\Controllers\StatisticsController22::class,
        'high_school' => App\Http\Controllers\HighSchoolStatisticsController22::class,
        'university' => App\Http\Controllers\UniversityStatisticsController22::class
    ],
    '2023-2024' => [
        'general' => App\Http\Controllers\StatisticsController23::class,
        'high_school' => App\Http\Controllers\HighSchoolStatisticsController23::class,
        'university' => App\Http\Controllers\UniversityStatisticsController23::class
    ],
    '2024-2025' => [
        'general' => App\Http\Controllers\StatisticsController24::class,
        'high_school' => App\Http\Controllers\HighSchoolStatisticsController24::class,
        'university' => App\Http\Controllers\UniversityStatisticsController24::class
    ]
];

// Rutas de las estadísticas escolares por año
foreach ($statisticsControllers as $period => $controllers){
    Route::prefix($period)->name('period_'.$period.'.')->group(function() use ($controllers, $period) {
        Route::get('/', function()  use ($period){
            $allRoutes = collect(Route::getRoutes())->map(function($route){
                return [
                    'uri' => $route->uri(),
                    'name' => $route->getName(),
                    'methods' => $route->methods(),
                    'action' => $route->getActionName()
                ];
            });
            $periodRoutes = $allRoutes->filter(function ($route) use ($period){
                return str_starts_with($route['uri'], $period);
            });
            return view('year-index',['period' => $period, 'routes' => $periodRoutes]);
        })->name('index');
        Route::get('/alumnos-y-docentes-por-genero', [$controllers['general'], 'students_teachers_gender'])->name('apg');
        Route::get('/alumnos-atendidos-por-tipo-o-nivel-educativo-y-por-sostenimiento', [$controllers['general'], 'students_school_level_sustenance'])->name('atnes');
        Route::get('/docentes-por-tipo-o-nivel-educativo-y-por-sostenimiento', [$controllers['general'], 'teachers_school_level_sustenance'])->name('dtnes');
        Route::get('/escuelas-por-tipo-o-nivel-educativo-y-por-sostenimiento', [$controllers['general'], 'schools_school_level_sustenance'])->name('etnes');
        Route::get('/proporción-de-alumnos-atendidos-por-tipo-o-nivel-educativo', [$controllers['general'], 'students_school_level_ratio'])->name('patne');
        Route::get('/inicial-escolarizado', [$controllers['general'], 'schooled_initial'])->name('ini');
        Route::get('/inicial-no-escolarizado', [$controllers['general'], 'non_schooled_initial'])->name('ine');
        Route::get('/especial-cam',[$controllers['general'], 'cam'])->name('cam');
        Route::get('/especial-usaer', [$controllers['general'], 'usaer'])->name('usaer');
        Route::get('/preescolar', [$controllers['general'], 'preschool'])->name('pre');
        Route::get('/primaria', [$controllers['general'], 'elementary_school'])->name('pri');
        Route::get('/secundaria', [$controllers['general'], 'middle_school'])->name('sec');
        Route::get('/media-superior', [$controllers['general'], 'high_school'])->name('ms');
        Route::get('/superior', [$controllers['general'], 'university'])->name('sup');
        Route::get('/alumnos-por-tipo-de-bachillerato', [$controllers['general'],'students_high_school_type'])->name('atb');
        Route::get('/educacion-media-superior-por-tipo-de-sostenimiento',[$controllers['general'],'high_schools_subcontrol'])->name('emsts');
        Route::get('/alumnos-por-subsistema-en-educación-media-superior',[$controllers['high_school'],'students_subsystems'])->name('asems');
        Route::get('/docentes-por-subsistema-en-educación-media-superior',[$controllers['high_school'],'teachers_subsystems'])->name('dsems');
        Route::get('/planteles-por-subsistema-en-educación-media-superior',[$controllers['high_school'],'schools_subsystems'])->name('psems');
        Route::get('/alumnos-nuevo-ingreso-egresados-por-subsistema-en-educacion-media-superior',[$controllers['high_school'], 'students_new_graduate'])->name('aniesems');
        Route::get('/alumnos-de-educacion-superior-por-nivel-o-grado', [$controllers['general'],'university_students_level_degree'])->name('aesng');
        Route::get('/alumnos-de-tsu-y-licenciatura', [$controllers['general'], 'tsu_lic_students'])->name('atl');
        Route::get('/alumnos-de-posgrado', [$controllers['general'], 'pos_students'])->name('ap');
        Route::get('/carreras-de-educacion-superior',[$controllers['general'],'university_study_programs'])->name('ces');
        Route::get('/carreras-de-tsu-y-licenciaturas',[$controllers['general'],'tsu_lic_study_programs'])->name('ctl');
        Route::get('/programas-de-posgrado',[$controllers['general'],'pos_study_programs'])->name('pp');
        Route::get('/educacion-superior-por-tipo-de-sostenimiento',[$controllers['general'],'universities_subcontrol'])->name('ests');
        Route::get('/carreras-alumnos-nuevo-ingreso-egresados-por-campos-de-formacion-de-tsu-y-licenciatura', [$controllers['university'], 'tsu_lic_carriers_students_new_graduate'])->name('aniecftl');
        Route::get('/carreras-alumnos-nuevo-ingreso-egresados-por-campos-de-formacion-de-posgrado', [$controllers['university'], 'pos_carriers_students_new_graduate'])->name('aniecfp');
        Route::get('/data-table', [$controllers['general'],'dataTable']);
        Route::get('/data-debug', [$controllers['general'], 'retrieveStatistics']);
    });
}
Route::get('/2021-2022/sample-charts', [App\Http\Controllers\StatisticsController21::class, 'sample_charts']);

// Estadísticas historícas
Route::get('/historico', [HistoricalStatisticsController::class, 'index']);

Route::get('/laravel-welcome', function () {
    return view('laravel-welcome');
});