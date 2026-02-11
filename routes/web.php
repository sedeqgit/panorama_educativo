<?php

use Illuminate\Support\Facades\Route;

// Controlador de estadísticas historicas
use App\Http\Controllers\HistoricalStatisticsController;

// Pagina de bienvenida
Route::get('/', function(){return view('welcome');})->name('welcome-page');

// Controladores de la estadísticas escolares
$statisticsControllers = [
    '2018-2019' => [
        'general' => App\Http\Controllers\Statistics\Controller18::class,
        'high_school' => App\Http\Controllers\HighSchoolStatistics\Controller18::class,
        'university' => App\Http\Controllers\UniversityStatistics\Controller18::class,
    ],
    '2019-2020' => [
        'general' => App\Http\Controllers\Statistics\Controller19::class,
        'high_school' => App\Http\Controllers\HighSchoolStatistics\Controller19::class,
        'university' => App\Http\Controllers\UniversityStatistics\Controller19::class
    ],
    '2020-2021' => [
        'general' => App\Http\Controllers\Statistics\Controller20::class,
        'high_school' => App\Http\Controllers\HighSchoolStatistics\Controller20::class,
        'university' => App\Http\Controllers\UniversityStatistics\Controller20::class
    ],
    '2021-2022' => [
        'general' => App\Http\Controllers\Statistics\Controller21::class,
        'high_school' => App\Http\Controllers\HighSchoolStatistics\Controller21::class,
        'university' => App\Http\Controllers\UniversityStatistics\Controller21::class
    ],
    '2022-2023' => [
        'general' => App\Http\Controllers\Statistics\Controller22::class,
        'high_school' => App\Http\Controllers\HighSchoolStatistics\Controller22::class,
        'university' => App\Http\Controllers\UniversityStatistics\Controller22::class
    ],
    '2023-2024' => [
        'general' => App\Http\Controllers\Statistics\Controller23::class,
        'high_school' => App\Http\Controllers\HighSchoolStatistics\Controller23::class,
        'university' => App\Http\Controllers\UniversityStatistics\Controller23::class
    ],
    '2024-2025' => [
        'general' => App\Http\Controllers\Statistics\Controller24::class,
        'high_school' => App\Http\Controllers\HighSchoolStatistics\Controller24::class,
        'university' => App\Http\Controllers\UniversityStatistics\Controller24::class
    ]
];

// Rutas de las estadísticas escolares por año
foreach ($statisticsControllers as $period => $controllers){
    Route::prefix($period)->name('period_'.$period)->group(function() use ($controllers, $period) {
        /*Route::get('/', function() use ($period){
            $allRoutes = collect(Route::getRoutes())->map(function($route){
                return [
                    'uri' => $route->uri(),
                    'name' => $route->getName()
                ];
            });
            $periodRoutes = $allRoutes->filter(function ($route) use ($period){
                return str_starts_with($route['uri'], $period);
            });
            //return view('period-index',['period' => $period, 'routes' => $periodRoutes]);
            return view('welcome',['period' => $period, 'routes' => $periodRoutes]);
        })->name('.index');*/
        
        Route::get('/estadistica-de-inicio-de-ciclo', [$controllers['general'], 'beginning_period_statistics'])->name('.eic');
        Route::get('/alumnos-y-docentes-por-genero', [$controllers['general'], 'students_teachers_gender'])->name('.apg');
        Route::get('/alumnos-atendidos-por-tipo-o-nivel-educativo-y-por-sostenimiento', [$controllers['general'], 'students_school_level_sustenance'])->name('.atnes');
        Route::get('/docentes-por-tipo-o-nivel-educativo-y-por-sostenimiento', [$controllers['general'], 'teachers_school_level_sustenance'])->name('.dtnes');
        Route::get('/escuelas-por-tipo-o-nivel-educativo-y-por-sostenimiento', [$controllers['general'], 'schools_school_level_sustenance'])->name('.etnes');
        Route::get('/proporción-de-alumnos-atendidos-por-tipo-o-nivel-educativo', [$controllers['general'], 'students_school_level_ratio'])->name('.patne');
        Route::prefix('niveles')->group(function() use ($controllers,$period){
            Route::prefix('inicial-escolarizado')->name('.ini')->group(function() use ($controllers){
                Route::get('/', [$controllers['general'], 'level_statistics'])->defaults('level','Inicial (Escolarizado)');
                Route::get('/federal-transferido', [$controllers['general'], 'transfered_level_statistics'])->defaults('level','Inicial (Escolarizado)')->name('ft');
            });
            if($period!="2018-2019"){
                Route::prefix('inicial-no-escolarizado')->name('.ine')->group(function() use ($controllers){
                    Route::get('/', [$controllers['general'], 'level_statistics'])->defaults('level','Inicial (No escolarizado)');
                    Route::get('/federal-transferido', [$controllers['general'], 'transfered_level_statistics'])->defaults('level','Inicial (No escolarizado)',)->name('ft');
                });
            }
            Route::prefix('especial-cam')->name('.cam')->group(function() use ($controllers){
                Route::get('/',[$controllers['general'], 'level_statistics'])->defaults('level','Especial (CAM)');
                Route::get('/federal-transferido',[$controllers['general'], 'transfered_level_statistics'])->defaults('level','Especial (CAM)')->name('ft');
            });
            Route::prefix('especial-usaer')->name('.usaer')->group(function() use ($controllers){
                Route::get('/', [$controllers['general'], 'level_statistics'])->defaults('level','Especial (USAER)');
                Route::get('/federal-transferido', [$controllers['general'], 'transfered_level_statistics'])->defaults('level','Especial (USAER)')->name('ft');
            });
            Route::prefix('preescolar')->name('.pre')->group(function() use ($controllers){
                Route::get('/', [$controllers['general'], 'level_statistics'])->defaults('level','Preescolar');
                Route::get('/federal-transferido', [$controllers['general'], 'transfered_level_statistics'])->defaults('level','Preescolar')->name('ft');
            });
            Route::prefix('primaria')->name('.pri')->group(function() use ($controllers){
                Route::get('/', [$controllers['general'], 'level_statistics'])->defaults('level','Primaria');
                Route::get('/federal-transferido', [$controllers['general'], 'transfered_level_statistics'])->defaults('level','Primaria')->name('ft');
            });
            Route::prefix('secundaria')->name('.sec')->group(function() use ($controllers){
                Route::get('/', [$controllers['general'], 'level_statistics'])->defaults('level','Secundaria');
                Route::get('/federal-transferido', [$controllers['general'], 'transfered_level_statistics'])->defaults('level','Secundaria')->name('ft');
            });
            Route::prefix('media-superior')->name('.ms')->group(function() use ($controllers){
                Route::get('/', [$controllers['general'], 'level_statistics'])->defaults('level','Media Superior');
                Route::get('/alumnos-por-tipo-de-bachillerato', [$controllers['general'],'students_high_school_type'])->name('.atb');
                Route::get('/por-tipo-de-sostenimiento',[$controllers['general'],'high_schools_subcontrol'])->name('.ts');
                Route::get('/matricula-por-subsistema',[$controllers['high_school'],'students_subsystems'])->name('.ms');
                Route::get('/docentes-por-subsistema',[$controllers['high_school'],'teachers_subsystems'])->name('.ds');
                Route::get('/planteles-por-subsistema',[$controllers['high_school'],'schools_subsystems'])->name('.ps');
                Route::get('/alumnos-nuevo-ingreso-egresados-por-subsistema',[$controllers['high_school'], 'students_new_graduate'])->name('.anies');
            });
            Route::prefix('superior')->name('.sup')->group(function() use ($controllers){
                Route::get('/', [$controllers['general'], 'level_statistics'])->defaults('level','Superior');
                Route::get('/por-tipo-de-sostenimiento',[$controllers['general'],'universities_subcontrol'])->name('.ts');
                Route::get('/matricula-por-nivel-o-grado', [$controllers['general'],'university_students_level_degree'])->name('.ang');
                Route::get('/matricula-de-tsu-y-licenciatura', [$controllers['general'], 'tsu_lic_students'])->name('.atl');
                Route::get('/matricula-de-posgrado', [$controllers['general'], 'pos_students'])->name('.ap');
                Route::get('/carreras',[$controllers['general'],'university_study_programs'])->name('.c');
                Route::get('/carreras-de-tsu-y-licenciaturas',[$controllers['general'],'tsu_lic_study_programs'])->name('.ctl');
                Route::get('/programas-de-posgrado',[$controllers['general'],'pos_study_programs'])->name('.cpp');
                Route::get('/carreras-matricula-nuevo-ingreso-egresados-por-campos-de-formacion-de-tsu-y-licenciatura', [$controllers['university'], 'tsu_lic_carriers_students_new_graduate'])->name('.caniecftl');
                Route::get('/carreras-matricula-nuevo-ingreso-egresados-por-campos-de-formacion-de-posgrado', [$controllers['university'], 'pos_carriers_students_new_graduate'])->name('.caniecfp');
                Route::get('/instituciones-con-mayor-matricula',[$controllers['university'], 'higher_enrollment_institutions'])->name('.imm');
                Route::get('/instituciones-con-mayor-matricula-tsu-y-licenciatura',[$controllers['university'], 'tsu_lic_higher_enrollment_institutions'])->name('.immtl');
                Route::get('/instituciones-con-mayor-matricula-posgrado',[$controllers['university'], 'pos_higher_enrollment_institutions'])->name('.immp');
            });
        });
        Route::get('/data-table', [$controllers['general'],'dataTable'])->name('.table');
        Route::get('/data-debug', [$controllers['general'], 'retrieveStatistics'])->name('.debug');
    });
}
Route::get('/2021-2022/sample-charts', [App\Http\Controllers\Statistics\Controller21::class, 'sample_charts']);