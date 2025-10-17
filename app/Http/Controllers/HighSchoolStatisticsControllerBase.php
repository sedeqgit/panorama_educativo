<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HighSchoolStatisticsControllerBase extends Controller
{
    // Variables de estructura y traducción de bases de datos
    protected array $queries_data_structure, $queries_rules;
    private array $subsystems_rules;

    // Variables de estadísticas
    private array $statistics;
    private array $schools;

    // Variables de bases de datos
    // Esquema de la base de datos
    private $database_schema;

    // Variables de nivel
    protected $ms_gral, $ms_tecno, $ms_plantel;

    protected function initializeDBVariables($cycle){
        $this->database_schema = "nonce_pano_".$cycle;
        $this->ms_gral = ".ms_gral_".$cycle;
        $this->ms_tecno = ".ms_tecno_".$cycle;
        $this->ms_plantel = ".ms_plantel_".$cycle;
    }

    protected function loadStatistics() {
        $municipalities=[
            "Amealco de Bonfil",
            "Pinal de Amoles",
            "Arroyo Seco",
            "Cadereyta de Montes",
            "Colón",
            "Corregidora",
            "Ezequiel Montes",
            "Huimilpan",
            "Jalpan de Serra",
            "Landa de Matamoros",
            "El Marqués",
            "Pedro Escobedo",
            "Peñamiller",
            "Querétaro",
            "San Joaquín",
            "San Juan del Río",
            "Tequisquiapan",
            "Tolimán"
        ];
        $this->subsystems_rules=[
            "CEDART" => function($q){
                $q->where("subsistema_2","=","INBA");
            },
            "DGETI" => function($q){
                $q->where("subsistema_2","=","DGETIS");
            },
            "CAED" => function($q){
                $q->where("subsistema_2","=","DGB");
            },
            "Particular" => function($q){
                $q->where("subsistema_2","=","PARTICULAR");
            },
            "Abierta" => function($q){
                $q->where("subsistema_2","=","PREPA ABIERTA ESTATAL");
            },
            "CONALEP" => function($q){
                $q->where("subsistema_2","=","CONALEP");
            },
            "DGETAyCM" => function($q){
                $q->where("subsistema_2","=","DGETAyCM");
            },
            "CENADART" => function($q){
                $q->where("subsistema_2","=","IEBAS");
            },
            "COBAQ" => function($q){
                $q->whereIn("subsistema_2",["COBACH", "EMSAD"]);
            },
            "CECyTEQ" => function($q){
                $q->where("subsistema_2","=","CECYTE");
            },
            "Telebachillerato" => function($q){
                $q->where("subsistema_2","=","TELEBACHILLERATO COMUNITARIO");
            },
            "UAQ" => function($q){
                $q->where("subsistema_2","LIKE","UNIVERSIDADES AUT%NOMAS ESTATALES");
            }
        ];
        foreach ($municipalities as $i => $municipality) {
            foreach ($this->queries_data_structure as $type => $tablenames) {
                foreach ($tablenames as $tablename => $colsmap) {
                    $type_condition=$this->queries_rules[$type];
                    foreach ($this->subsystems_rules as $subsystem => $subsytem_filter){
                        $query = DB::table($this->database_schema.$tablename);
                        $selects = [];
                        foreach ($colsmap as $col => $colname) {
                            if ($col=="school_count"){
                                $selects[] = DB::raw("COUNT($colname) AS $col");
                            } else{
                                $selects[] = DB::raw("SUM($colname) AS $col");
                            }
                        }
                        $schools=DB::table($this->database_schema.$this->ms_plantel)->where("cv_mun","=",($i+1))->where("cv_motivo","=","0")->pluck("cct_ins_pla")->values()->toArray();
                        if (!isset($this->schools[$municipality])) $this->schools[$municipality] = count($schools);
                        $query->where("cv_mun","=",($i+1))->where($type_condition($query))->where($subsytem_filter);
                        $data = $query->select($selects)->first();
                        if (!isset($this->statistics[$municipality])) $this->statistics[$municipality] = [];
                        if (!isset($this->statistics[$municipality][$subsystem])) $this->statistics[$municipality][$subsystem] = [];
                        foreach ($colsmap as $col => $colname) {
                            $this->statistics[$municipality][$subsystem][$col] = ($this->statistics[$municipality][$subsystem][$col] ?? 0) + ($data->$col);
                        }
                    }
                }
            }
        }
    }

    private function getSubsystems(){
        $subsystems = [];
        foreach ($this->subsystems_rules as $subsystem => $subsystem_filter) array_push($subsystems, $subsystem);
        return $subsystems;
    }

    private function getStatisticsBySubsystems(){
        $totals_by_subsystem = [];
        foreach ($this->statistics as $municipality => $subsystems) {
            foreach ($subsystems as $subsystem => $data) {
                foreach ($data as $key => $value) {
                    if (!isset($totals_by_subsystem[$subsystem])) $totals_by_subsystem[$subsystem] = [];
                    $totals_by_subsystem[$subsystem][$key] = ($totals_by_subsystem[$subsystem][$key] ?? 0) + ($value);
                }
            }
        }
        return $totals_by_subsystem;
    }

    public function students_subsystems(){
        try{
            $subsystems = $this->getSubsystems();
            $totals_by_subsystem = $this->getStatisticsBySubsystems();
            return view('students-high-school-subsystems',['statistics' => $this->statistics, 'subsystems' => $subsystems, 'totals_by_subsystem' => $totals_by_subsystem]);
        } catch (\Exception $e){
            return view('page-under-construction');
        }
    }

    public function teachers_subsystems(){
        try{
            $subsystems = $this->getSubsystems();
            $totals_by_subsystem = $this->getStatisticsBySubsystems();
            return view('teachers-high-school-subsystems',['statistics' => $this->statistics, 'subsystems' => $subsystems, 'totals_by_subsystem' => $totals_by_subsystem]);
        } catch (\Exception $e){
            return view('page-under-construction');
        }
    }

    public function schools_subsystems(){
        try{
            $subsystems = $this->getSubsystems();
            $totals_by_subsystem = $this->getStatisticsBySubsystems();
            return view('schools-high-school-subsystems',['statistics' => $this->statistics, 'subsystems' => $subsystems, 'totals_by_subsystem' => $totals_by_subsystem]);
        } catch (\Exception $e){
            return view('page-under-construction');
        }
    }
}
