<?php

namespace App\Http\Controllers\Statistics;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Base extends Controller
{
    // Variables de estructura y traducción de bases de datos
    protected array $queries_data_structure, $queries_rules;
    protected array $query_data_structure_for_university_schools_details;

    // Variables de estadísticas
    private array $statistics;
    private array $high_schools;
    private array $universities_details;

    // Variables de bases de datos
    // Esquema de la base de datos
    private $database_schema;

    // Inicial (Escolarizado)
    protected $ini_gral, $ini_ind;

    // Inicial (No escolarizado)
    protected $ini_ne, $ini_comuni;

    // Especial (CAM)
    protected $esp_cam;

    //Especial (USAER)
    protected $esp_usaer;

    // Preescolar
    protected $pree_gral, $pree_comuni, $pree_ind;

    // Primaria
    protected $prim_gral, $prim_comuni, $prim_ind;

    // Secundaria
    protected $sec_gral, $sec_comuni;

    // Media superior
    protected $ms_gral, $ms_tecno, $ms_plantel;

    // Superior
    protected $sup_carrera, $sup_escuela, $sup_posgrado;

    // Inicialización de las variables de la base de datos
    protected function initializeDBVariables($cycle){
        $this->database_schema = "nonce_pano_".$cycle;
        $this->ini_gral = ".ini_gral_".$cycle;
        $this->ini_ind = ".ini_ind_".$cycle;
        $this->ini_ne = ".ini_ne_".$cycle;
        $this->ini_comuni = ".ini_comuni_".$cycle;
        $this->esp_cam = ".esp_cam_".$cycle;
        $this->esp_usaer = ".esp_usaer_".$cycle;
        $this->pree_gral = ".pree_gral_".$cycle;
        $this->pree_comuni = ".pree_comuni_".$cycle;
        $this->pree_ind = ".pree_ind_".$cycle;
        $this->prim_gral = ".prim_gral_".$cycle;
        $this->prim_comuni = ".prim_comuni_".$cycle;
        $this->prim_ind = ".prim_ind_".$cycle;
        $this->sec_gral = ".sec_gral_".$cycle;
        $this->sec_comuni = ".sec_comuni_".$cycle;
        $this->ms_gral = ".ms_gral_".$cycle;
        $this->ms_tecno = ".ms_tecno_".$cycle;
        $this->ms_plantel = ".ms_plantel_".$cycle;
        $this->sup_carrera = ".sup_carrera_".$cycle;
        $this->sup_escuela = ".sup_escuela_".$cycle;
        $this->sup_posgrado = ".sup_posgrado_".$cycle;
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
        $controls_queries_rules=[
            "Público" => [
                "Estatal" => function($q){
                    $q->where("subcontrol","=","ESTATAL");
                },
                "Federal" => function($q){
                    $q->where("subcontrol","=","FEDERAL");
                },
                "Federal Transferido" => function($q){
                    $q->where("subcontrol","=","FEDERAL TRANSFERIDO");
                },
                "Autónomo" => function($q){
                    $q->whereNotIn("subcontrol", ["ESTATAL","FEDERAL","FEDERAL TRANSFERIDO","PRIVADO"]);
                },
            ],
            "Privado" => [
                "Privado" => function($q) {
                    $q->where("subcontrol","=","PRIVADO");
                }
            ]
        ];
        foreach ($municipalities as $i => $municipality) {
            foreach ($this->queries_data_structure as $level => $types) {
                foreach ($types as $type => $tablenames) {
                    foreach ($tablenames as $tablename => $colsmap) {
                        $type_condition=$this->queries_rules[$level][$type];
                        foreach ($controls_queries_rules as $control => $subcontrols) {
                            foreach ($subcontrols as $subcontrol => $subcontrol_condition) {
                                $query = DB::table($this->database_schema.$tablename);
                                $selects = [];
                                foreach ($colsmap as $col => $colname) {
                                    if(($type=="Comunitario" && $col== "groups") || ((($level=="Preescolar" && $type=="General") || $type=="gral_dir" || $type=="doc") && $col=="school_count")){
                                        $selects[] = DB::raw("$colname AS $col");
                                    } elseif ($col=="school_count" || $col=="carriers"){
                                        $selects[] = DB::raw("COUNT($colname) AS $col");
                                    } else{
                                        $selects[] = DB::raw("SUM($colname) AS $col");
                                    }
                                }
                                $schools = [];
                                switch ($level) {
                                    case "Media Superior":
                                        $schools=DB::table($this->database_schema.$this->ms_plantel)->where("cv_mun","=",($i+1))->where("cv_motivo","=","0")->where($subcontrol_condition)->pluck("cct_ins_pla")->values()->toArray();
                                        break;
                                    case "Superior":
                                        $schools=DB::table($this->database_schema.$this->sup_escuela)->where("cv_mun","=",($i+1))->where("cv_motivo","=","0")->where($subcontrol_condition)->pluck("cct_ins_pla")->unique()->values()->toArray();
                                        break;
                                }
                                $query->where("cv_mun","=",($i+1))->where($subcontrol_condition)->where($type_condition($query))->select($selects);
                                $data = $query->first();
                                $last_type=$type;
                                if ($type=="gral_dir") $type = "General";
                                if ($type=="doc") $type = "total";
                                if (!isset($this->statistics[$municipality])) $this->statistics[$municipality] = [];
                                if (!isset($this->statistics[$municipality][$level])) $this->statistics[$municipality][$level] = [];
                                if (!isset($this->statistics[$municipality][$level][$type])) $this->statistics[$municipality][$level][$type] = [];
                                if (!isset($this->statistics[$municipality][$level][$type][$control])) $this->statistics[$municipality][$level][$type][$control] = [];
                                if (!isset($this->statistics[$municipality][$level][$type][$control][$subcontrol])) $this->statistics[$municipality][$level][$type][$control][$subcontrol] = [];
                                if ($level == "Media Superior") {
                                    if (!isset($this->high_schools[$municipality])) $this->high_schools[$municipality] = [];
                                    if (!isset($this->high_schools[$municipality][$control])) $this->high_schools[$municipality][$control] = [];
                                    if (!isset($this->high_schools[$municipality][$control][$subcontrol])) $this->high_schools[$municipality][$control][$subcontrol] = count($schools);
                                }
                                foreach ($colsmap as $col => $colname) {
                                    $this->statistics[$municipality][$level][$type][$control][$subcontrol][$col] = ($this->statistics[$municipality][$level][$type][$control][$subcontrol][$col] ?? 0) + ($data->$col ?? 0);
                                }
                                $type=$last_type;
                            }
                        }
                    }
                }
            }
            foreach ($controls_queries_rules as $control => $subcontrols){
                foreach ($subcontrols as $subcontrol => $subcontrol_condition){
                    $query = DB::table($this->database_schema.$this->sup_escuela);
                    $selects = [];
                    foreach ($this->query_data_structure_for_university_schools_details as $col => $colname){
                        if ($col == 'school_count'){
                            $selects[] = DB::raw("COUNT($colname) AS $col");
                        } else {
                            $selects[] = DB::raw("SUM($colname) AS $col");
                        }
                    }
                    $query->where("cv_mun","=",($i+1))->where($subcontrol_condition)->where("cv_motivo","=","0")->select($selects);
                    $data = $query->first();
                    if (!isset($this->universities_details[$municipality])) $this->universities_details[$municipality] = [];
                    if (!isset($this->universities_details[$municipality][$control])) $this->universities_details[$municipality][$control] = [];
                    if (!isset($this->universities_details[$municipality][$control][$subcontrol])) $this->universities_details[$municipality][$control][$subcontrol] = [];
                    foreach ($this->query_data_structure_for_university_schools_details as $col => $colname){
                        $this->universities_details[$municipality][$control][$subcontrol][$col] = ($this->universities_details[$municipality][$control][$subcontrol][$col] ?? 0) + ($data->$col ?? 0);
                    }
                }
            }
        }
    }

    private function getStatisticsOfTotals(){
        $statistics_of_totals = [];
        $high_schools = 0;
        foreach ($this->high_schools as $municipality => $controls){
            foreach ($controls as $control => $subcontrols){
                foreach ($subcontrols as $subcontrol => $schools) {
                    $high_schools+=$schools;
                }
            }
        }
        $universities_details = [];
        foreach ($this->universities_details as $municipality => $controls){
            foreach ($controls as $control => $subcontrols){
                foreach ($subcontrols as $subcontrol => $data) {
                    foreach ($data as $key => $value){
                        $universities_details[$key] = ($universities_details[$key] ?? 0) + ($data[$key]);
                    }
                }
            }
        }
        foreach ($this->statistics as $municipality => $levels){
            foreach($levels as $level => $types){
                foreach ($types as $type => $controls){
                    foreach ($controls as $control => $subcontrols){
                        foreach ($subcontrols as $subcontrol => $data){
                            foreach ($data as $key => $value) {
                                if ($level == "Media Superior" && $key == "school_count") {
                                    $statistics_of_totals[$key] = $high_schools;
                                } elseif ($level == "Superior" && ($key == "school_count" || $key == "male_teachers" || $key == "female_teachers")) {
                                    $statistics_of_totals[$key] = $universities_details[$key];
                                } elseif ($level == "Especial (USAER)" && ($key=="female_students" || $key=="male_students" || $key=="school_count")){
                                } else {
                                    $statistics_of_totals[$key] = ($statistics_of_totals[$key] ?? 0) + ($data[$key]);
                                }
                            }
                        }
                    }
                }
            }
        }
        return $statistics_of_totals;
    }

    private function getStatisticsOfTotalsByLevels(){
        $statistics_of_totals = [];
        $high_schools = 0;
        foreach ($this->high_schools as $municipality => $controls){
            foreach ($controls as $control => $subcontrols){
                foreach ($subcontrols as $subcontrol => $schools) {
                    $high_schools+=$schools;
                }
            }
        }
        $universities_details = [];
        foreach ($this->universities_details as $municipality => $controls){
            foreach ($controls as $control => $subcontrols){
                foreach ($subcontrols as $subcontrol => $data) {
                    foreach ($data as $key => $value){
                        $universities_details[$key] = ($universities_details[$key] ?? 0) + ($data[$key]);
                    }
                }
            }
        }
        foreach ($this->statistics as $municipality => $levels){
            foreach($levels as $level => $types){
                foreach ($types as $type => $controls){
                    foreach ($controls as $control => $subcontrols){
                        foreach ($subcontrols as $subcontrol => $data){
                            foreach ($data as $key => $value) {
                                if (!isset($statistics_of_totals[$level])) $statistics_of_totals[$level] = [];
                                if ($level == "Media Superior" && $key == "school_count") {
                                    $statistics_of_totals[$level][$key] = $high_schools;
                                } elseif ($level == "Superior" && ($key == "school_count" || $key == "male_teachers" || $key == "female_teachers")) {
                                    $statistics_of_totals[$level][$key] = $universities_details[$key];
                                } else {
                                    $statistics_of_totals[$level][$key] = ($statistics_of_totals[$level][$key] ?? 0) + ($data[$key]);
                                }
                            }
                        }
                    }
                }
            }
        }
        return $statistics_of_totals;
    }

    private function getStatisticsOfTotalsByLevelsAndControl(){
        $statistics_of_totals = [];
        $high_schools = [];
        foreach ($this->high_schools as $municipality => $controls){
            foreach ($controls as $control => $subcontrols){
                foreach ($subcontrols as $subcontrol => $schools) {
                    if(!isset($high_schools[$control])) $high_schools[$control] = 0;
                    $high_schools[$control]+=$schools;
                }
            }
        }
        $universities_details = [];
        foreach ($this->universities_details as $municipality => $controls){
            foreach ($controls as $control => $subcontrols){
                foreach ($subcontrols as $subcontrol => $data) {
                    foreach ($data as $key => $value){
                        if(!isset($universities_details[$control])) $universities_details[$control] = [];
                        $universities_details[$control][$key] = ($universities_details[$control][$key] ?? 0) + ($data[$key]);
                    }
                }
            }
        }
        foreach($this->statistics as $municipality => $levels){
            foreach($levels as $level => $types){
                foreach ($types as $type => $controls){
                    foreach ($controls as $control => $subcontrols){
                        foreach ($subcontrols as $subcontrol => $data){
                            foreach ($data as $key => $value) {
                                if (!isset($statistics_of_totals[$level])) $statistics_of_totals[$level] = [];
                                if (!isset($statistics_of_totals[$level][$control])) $statistics_of_totals[$level][$control] = [];
                                if (($level == "Media Superior") && $key == "school_count"){
                                    $statistics_of_totals[$level][$control][$key] = $high_schools[$control];
                                } elseif ($level == "Superior" && ($key == "school_count" || $key == "male_teachers" || $key == "female_teachers")) {
                                    $statistics_of_totals[$level][$control][$key] = $universities_details[$control][$key];
                                } else {
                                    $statistics_of_totals[$level][$control][$key] = ($statistics_of_totals[$level][$control][$key] ?? 0) + ($data[$key]);
                                }
                            }
                        }
                    }
                }
            }
        }
        return $statistics_of_totals;
    }

    private function getStatisticsOfTotalsByControl(){
        $statistics_of_totals = [];
        $high_schools = [];
        foreach ($this->high_schools as $municipality => $controls){
            foreach ($controls as $control => $subcontrols){
                foreach ($subcontrols as $subcontrol => $schools) {
                    if(!isset($high_schools[$control])) $high_schools[$control] = 0;
                    $high_schools[$control]+=$schools;
                }
            }
        }
        $universities_details = [];
        foreach ($this->universities_details as $municipality => $controls){
            foreach ($controls as $control => $subcontrols){
                foreach ($subcontrols as $subcontrol => $data) {
                    foreach ($data as $key => $value){
                        if(!isset($universities_details[$control])) $universities_details[$control] = [];
                        $universities_details[$control][$key] = ($universities_details[$control][$key] ?? 0) + ($data[$key]);
                    }
                }
            }
        }
        foreach($this->statistics as $municipality => $levels){
            foreach($levels as $level => $types){
                foreach ($types as $type => $controls){
                    foreach ($controls as $control => $subcontrols){
                        foreach ($subcontrols as $subcontrol => $data){
                            foreach ($data as $key => $value) {
                                if (!isset($statistics_of_totals[$control])) $statistics_of_totals[$control] = [];
                                if (($level == "Media Superior") && $key == "school_count"){
                                    $statistics_of_totals[$control][$key] = $high_schools[$control];
                                } elseif ($level == "Superior" && ($key == "school_count" || $key == "male_teachers" || $key == "female_teachers")) {
                                    $statistics_of_totals[$control][$key] = $universities_details[$control][$key];
                                } elseif ($level == "Especial (USAER)" && ($key=="female_students" || $key=="male_students" || $key=="school_count")){
                                } else {
                                    $statistics_of_totals[$control][$key] = ($statistics_of_totals[$control][$key] ?? 0) + ($data[$key]);
                                }
                            }
                        }
                    }
                }
            }
        }
        return $statistics_of_totals;
    }

    private function getStatisticsOfLevel($level_to_look_up){
        $statistics_of_level = [];
        $high_schools = 0;
        foreach ($this->high_schools as $municipality => $controls){
            foreach ($controls as $control => $subcontrols){
                foreach ($subcontrols as $subcontrol => $schools) {
                    $high_schools+=$schools;
                }
            }
        }
        $universities_details = [];
        foreach ($this->universities_details as $municipality => $controls){
            foreach ($controls as $control => $subcontrols){
                foreach ($subcontrols as $subcontrol => $data) {
                    foreach ($data as $key => $value){
                        $universities_details[$key] = ($universities_details[$key] ?? 0) + ($data[$key]);
                    }
                }
            }
        }
        foreach ($this->statistics as $municipality => $levels){
            foreach($levels as $level => $types){
                if ($level_to_look_up == $level) {
                    foreach ($types as $type => $controls){
                        foreach ($controls as $control => $subcontrols){
                            foreach ($subcontrols as $subcontrol => $data){
                                foreach ($data as $key => $value) {
                                    if ($level == "Media Superior" && $key == "school_count") {
                                        $statistics_of_level[$key] = $high_schools;
                                    } elseif ($level == "Superior" && ($key == "school_count" || $key == "male_teachers" || $key == "female_teachers")) {
                                        $statistics_of_level[$key] = $universities_details[$key];
                                    } else {
                                        $statistics_of_level[$key] = ($statistics_of_level[$key] ?? 0) + ($data[$key]);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return $statistics_of_level;
    }

    private function getStatisticsOfLevelAndSubcontrol($level_to_look_up,$subcontrol_to_lookup){
        $statistics_of_level = [];
        $high_schools = [];
        if ($level_to_look_up=="Media Superior"){
            foreach ($this->high_schools as $municipality => $controls){
                foreach ($controls as $control => $subcontrols){
                    foreach ($subcontrols as $subcontrol => $schools) {
                        if(!isset($high_schools[$subcontrol])) $high_schools[$subcontrol] = 0;
                        $high_schools[$subcontrol]+=$schools;
                    }
                }
            }
        }
        $universities_details = [];
        if ($level_to_look_up=="Superior"){
            foreach ($this->universities_details as $municipality => $controls){
                foreach ($controls as $control => $subcontrols){
                    foreach ($subcontrols as $subcontrol => $data) {
                        foreach ($data as $key => $value){
                            if(!isset($universities_details[$subcontrol])) $universities_details[$subcontrol] = [];
                            $universities_details[$subcontrol][$key] = ($universities_details[$subcontrol][$key] ?? 0) + ($data[$key]);
                        }
                    }
                }
            }
        }
        foreach ($this->statistics as $municipality => $levels){
            foreach($levels as $level => $types){
                if ($level_to_look_up == $level) {
                    foreach ($types as $type => $controls){
                        foreach ($controls as $control => $subcontrols){
                            foreach ($subcontrols as $subcontrol => $data){
                                if ($subcontrol==$subcontrol_to_lookup) {
                                    foreach ($data as $key => $value) {
                                        if ($level == "Media Superior" && $key == "school_count") {
                                            $statistics_of_level[$key] = $high_schools[$subcontrol];
                                        } elseif ($level == "Superior" && ($key == "school_count" || $key == "male_teachers" || $key == "female_teachers")) {
                                            $statistics_of_level[$key] = $universities_details[$subcontrol][$key];
                                        } else {
                                            $statistics_of_level[$key] = ($statistics_of_level[$key] ?? 0) + ($data[$key]);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return $statistics_of_level;
    }

    private function getStatisticsOfLevelByTypes($level_to_look_up){
        $statistics_of_level = [];
        foreach ($this->statistics as $municipality => $levels){
            foreach($levels as $level => $types){
                if ($level_to_look_up == $level) {
                    foreach ($types as $type => $controls){
                        foreach ($controls as $control => $subcontrols){
                            foreach ($subcontrols as $subcontrol => $data){
                                foreach ($data as $key => $value) {
                                    if (!isset($statistics_of_level[$type])) $statistics_of_level[$type] = [];
                                    $statistics_of_level[$type][$key] = ($statistics_of_level[$type][$key] ?? 0) + ($data[$key]);
                                }
                            }
                        }
                    }
                }
            }
        }
        return $statistics_of_level;
    }

    private function getStatisticsOfLevelsByControl(array $levels_to_look_up){
        $statistics_of_level = [];
        $only_one = count($levels_to_look_up) == 1;
        $high_schools = [];
        $universities_details = [];
        foreach ($levels_to_look_up as $level_to_look_up){
            if ($level_to_look_up=="Media Superior"){
                foreach ($this->high_schools as $municipality => $controls){
                    foreach ($controls as $control => $subcontrols){
                        foreach ($subcontrols as $subcontrol => $schools) {
                            if(!isset($high_schools[$control])) $high_schools[$control] = 0;
                            $high_schools[$control]+=$schools;
                        }
                    }
                }
            }
            if ($level_to_look_up== "Superior"){
                        foreach ($this->universities_details as $municipality => $controls){
                    foreach ($controls as $control => $subcontrols){
                        foreach ($subcontrols as $subcontrol => $data) {
                            foreach ($data as $key => $value){
                                if(!isset($universities_details[$control])) $universities_details[$control] = [];
                                $universities_details[$control][$key] = ($universities_details[$control][$key] ?? 0) + ($data[$key]);
                            }
                        }
                    }
                }
            }
        }
        foreach ($this->statistics as $municipality => $levels){
            foreach($levels as $level => $types){
                foreach ($levels_to_look_up as $level_to_look_up){
                    if ($level_to_look_up == $level) {
                        foreach ($types as $type => $controls){
                            foreach ($controls as $control => $subcontrols){
                                foreach ($subcontrols as $subcontrol => $data){
                                    foreach ($data as $key => $value) {
                                        if (!isset($statistics_of_level[$control])) $statistics_of_level[$control] = [];
                                        if ($level == "Media Superior" && $key == "school_count") {
                                            $statistics_of_level[$control][$key] = $high_schools[$control];
                                        } elseif ($level == "Superior" && ($key == "school_count" || $key == "male_teachers" || $key == "female_teachers")) {
                                            $statistics_of_level[$control][$key] = $universities_details[$control][$key];
                                        } elseif (!$only_one && $level=="Especial (USAER)"  && ($key=="female_students" || $key=="male_students" || $key=="school_count")){
                                        } else {
                                            $statistics_of_level[$control][$key] = ($statistics_of_level[$control][$key] ?? 0) + ($data[$key]);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return $statistics_of_level;
    }

    private function getStatisticsOfLevelBySubcontrol($level_to_look_up){
        $statistics_of_level = [];
        $high_schools = [];
        $universities_details = [];
        if ($level_to_look_up=="Media Superior"){
            foreach ($this->high_schools as $municipality => $controls){
                foreach ($controls as $control => $subcontrols){
                    foreach ($subcontrols as $subcontrol => $schools) {
                        if(!isset($high_schools[$subcontrol])) $high_schools[$subcontrol] = 0;
                        $high_schools[$subcontrol]+=$schools;
                    }
                }
            }
        }
        if ($level_to_look_up== "Superior"){
            foreach ($this->universities_details as $municipality => $controls){
                foreach ($controls as $control => $subcontrols){
                    foreach ($subcontrols as $subcontrol => $data) {
                        foreach ($data as $key => $value){
                            if(!isset($universities_details[$subcontrol])) $universities_details[$subcontrol] = [];
                            $universities_details[$subcontrol][$key] = ($universities_details[$subcontrol][$key] ?? 0) + ($data[$key]);
                        }
                    }
                }
            }
        }
        foreach ($this->statistics as $municipality => $levels){
            foreach($levels as $level => $types){
                if ($level_to_look_up == $level) {
                    foreach ($types as $type => $controls){
                        foreach ($controls as $control => $subcontrols){
                            foreach ($subcontrols as $subcontrol => $data){
                                foreach ($data as $key => $value) {
                                    if (!isset($statistics_of_level[$subcontrol])) $statistics_of_level[$subcontrol] = [];
                                    if ($level == "Media Superior" && $key == "school_count") {
                                        $statistics_of_level[$subcontrol][$key] = $high_schools[$subcontrol];
                                    } elseif ($level == "Superior" && ($key == "school_count" || $key == "male_teachers" || $key == "female_teachers")) {
                                        $statistics_of_level[$subcontrol][$key] = $universities_details[$subcontrol][$key];
                                    } else {
                                        $statistics_of_level[$subcontrol][$key] = ($statistics_of_level[$subcontrol][$key] ?? 0) + ($data[$key]);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return $statistics_of_level;
    }

    private function getStatisticsOfLevelByMunicipalities($level_to_look_up){
        $statistics_of_level = [];
        $high_schools = [];
        $universities_details = [];
        if ($level_to_look_up=="Media Superior"){
            foreach ($this->high_schools as $municipality => $controls){
                foreach ($controls as $control => $subcontrols){
                    foreach ($subcontrols as $subcontrol => $schools) {
                        if(!isset($high_schools[$municipality])) $high_schools[$municipality] = 0;
                        $high_schools[$municipality]+=$schools;
                    }
                }
            }
        }
        if ($level_to_look_up== "Superior"){
            foreach ($this->universities_details as $municipality => $controls){
                foreach ($controls as $control => $subcontrols){
                    foreach ($subcontrols as $subcontrol => $data) {
                        foreach ($data as $key => $value){
                            if(!isset($universities_details[$municipality])) $universities_details[$municipality] = [];
                            $universities_details[$municipality][$key] = ($universities_details[$municipality][$key] ?? 0) + ($data[$key]);
                        }
                    }
                }
            }
        }
        foreach ($this->statistics as $municipality => $levels){
            foreach($levels as $level => $types){
                if ($level_to_look_up == $level) {
                    foreach ($types as $type => $controls){
                        foreach ($controls as $control => $subcontrols){
                            foreach ($subcontrols as $subcontrol => $data){
                                foreach ($data as $key => $value) {
                                    if (!isset($statistics_of_level[$municipality])) $statistics_of_level[$municipality] = [];
                                    if ($level == "Media Superior" && $key == "school_count") {
                                        $statistics_of_level[$municipality][$key] = $high_schools[$municipality];
                                    } elseif ($level == "Superior" && ($key == "school_count" || $key == "male_teachers" || $key == "female_teachers")) {
                                        $statistics_of_level[$municipality][$key] = $universities_details[$municipality][$key];
                                    } else {
                                        $statistics_of_level[$municipality][$key] = ($statistics_of_level[$municipality][$key] ?? 0) + ($data[$key]);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return $statistics_of_level;
    }

    private function getStatisticsOfLevelAndSubcontrolByMunicipalities($level_to_look_up,$subcontrol_to_lookup){
        $statistics_of_level = [];
        $high_schools = [];
        $universities_details = [];
        if ($level_to_look_up=="Media Superior"){
            foreach ($this->high_schools as $municipality => $controls){
                foreach ($controls as $control => $subcontrols){
                    foreach ($subcontrols as $subcontrol => $schools) {
                        if(!isset($high_schools[$municipality])) $high_schools[$municipality] = 0;
                        $high_schools[$municipality]+=$schools;
                    }
                }
            }
        }
        if ($level_to_look_up== "Superior"){
            foreach ($this->universities_details as $municipality => $controls){
                foreach ($controls as $control => $subcontrols){
                    foreach ($subcontrols as $subcontrol => $data) {
                        foreach ($data as $key => $value){
                            if(!isset($universities_details[$municipality])) $universities_details[$municipality] = [];
                            $universities_details[$municipality][$key] = ($universities_details[$municipality][$key] ?? 0) + ($data[$key]);
                        }
                    }
                }
            }
        }
        foreach ($this->statistics as $municipality => $levels){
            foreach($levels as $level => $types){
                if ($level_to_look_up == $level) {
                    foreach ($types as $type => $controls){
                        foreach ($controls as $control => $subcontrols){
                            foreach ($subcontrols as $subcontrol => $data){
                                if ($subcontrol==$subcontrol_to_lookup){
                                    foreach ($data as $key => $value) {
                                        if (!isset($statistics_of_level[$municipality])) $statistics_of_level[$municipality] = [];
                                        if ($level == "Media Superior" && $key == "school_count") {
                                            $statistics_of_level[$municipality][$key] = $high_schools[$municipality];
                                        } elseif ($level == "Superior" && ($key == "school_count" || $key == "male_teachers" || $key == "female_teachers")) {
                                            $statistics_of_level[$municipality][$key] = $universities_details[$municipality][$key];
                                        } else {
                                            $statistics_of_level[$municipality][$key] = ($statistics_of_level[$municipality][$key] ?? 0) + ($data[$key]);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return $statistics_of_level;
    }

    private function getStatisticsOfLevelByMunicipalitiesAndControls($level_to_look_up){
        $statistics_of_level = [];
        $high_schools = [];
        $universities_details = [];
        if ($level_to_look_up=="Media Superior"){
            foreach ($this->high_schools as $municipality => $controls){
                foreach ($controls as $control => $subcontrols){
                    foreach ($subcontrols as $subcontrol => $schools) {
                        if(!isset($high_schools[$municipality])) $high_schools[$municipality] = [];
                        if(!isset($high_schools[$municipality][$control])) $high_schools[$municipality][$control] = 0;
                        $high_schools[$municipality][$control]+=$schools;
                    }
                }
            }
        }
        if ($level_to_look_up== "Superior"){
            foreach ($this->universities_details as $municipality => $controls){
                foreach ($controls as $control => $subcontrols){
                    foreach ($subcontrols as $subcontrol => $data) {
                        foreach ($data as $key => $value){
                            if(!isset($universities_details[$municipality])) $universities_details[$municipality] = [];
                            if(!isset($universities_details[$municipality][$control])) $universities_details[$municipality][$control] = [];
                            $universities_details[$municipality][$control][$key] = ($universities_details[$municipality][$control][$key] ?? 0) + ($data[$key]);
                        }
                    }
                }
            }
        }
        foreach ($this->statistics as $municipality => $levels){
            foreach($levels as $level => $types){
                if ($level_to_look_up == $level) {
                    foreach ($types as $type => $controls){
                        foreach ($controls as $control => $subcontrols){
                            foreach ($subcontrols as $subcontrol => $data){
                                foreach ($data as $key => $value) {
                                    if (!isset($statistics_of_level[$municipality])) $statistics_of_level[$municipality] = [];
                                    if (!isset($statistics_of_level[$municipality][$control])) $statistics_of_level[$municipality][$control] = [];
                                    if ($level == "Media Superior" && $key == "school_count") {
                                        $statistics_of_level[$municipality][$control][$key] = $high_schools[$municipality][$control];
                                    } elseif ($level == "Superior" && ($key == "school_count" || $key == "male_teachers" || $key == "female_teachers")) {
                                        $statistics_of_level[$municipality][$control][$key] = $universities_details[$municipality][$control][$key];
                                    } else {
                                        $statistics_of_level[$municipality][$control][$key] = ($statistics_of_level[$municipality][$control][$key] ?? 0) + ($data[$key]);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        //dd($statistics_of_level);
        return $statistics_of_level;
    }

    private function getStatisticsOfLevelByTypesAndControls($level_to_look_up){
        $statistics_of_level = [];
        foreach ($this->statistics as $municipality => $levels){
            foreach($levels as $level => $types){
                if ($level_to_look_up == $level) {
                    foreach ($types as $type => $controls){
                        foreach ($controls as $control => $subcontrols){
                            foreach ($subcontrols as $subcontrol => $data){
                                foreach ($data as $key => $value) {
                                    if (!isset($statistics_of_level[$type])) $statistics_of_level[$type] = [];
                                    if (!isset($statistics_of_level[$type][$control])) $statistics_of_level[$type][$control] = [];
                                    $statistics_of_level[$type][$control][$key] = ($statistics_of_level[$type][$control][$key] ?? 0) + ($data[$key]);
                                }
                            }
                        }
                    }
                }
            }
        }
        return $statistics_of_level;
    }

    private function getStatisticsOfLevelAndSubcontrolByTypes($level_to_look_up,$subcontrol_to_lookup){
        $statistics_of_level = [];
        foreach ($this->statistics as $municipality => $levels){
            foreach($levels as $level => $types){
                if ($level_to_look_up == $level) {
                    foreach ($types as $type => $controls){
                        foreach ($controls as $control => $subcontrols){
                            foreach ($subcontrols as $subcontrol => $data){
                                if ($subcontrol == $subcontrol_to_lookup){
                                    foreach ($data as $key => $value) {
                                        if (!isset($statistics_of_level[$type])) $statistics_of_level[$type] = [];
                                        $statistics_of_level[$type][$key] = ($statistics_of_level[$type][$key] ?? 0) + ($data[$key]);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return $statistics_of_level;
    }

    private function getStatisticsOfLevelAndTypes($level_to_look_up, array $types_to_look_up){
        $statistics_of_level = [];
        foreach ($this->statistics as $municipality => $levels){
            foreach($levels as $level => $types){
                if ($level_to_look_up == $level) {
                    foreach ($types as $type => $controls){
                        foreach ($types_to_look_up as $type_to_look_up){
                            if ($type_to_look_up == $type) {
                                foreach ($controls as $control => $subcontrols){
                                    foreach ($subcontrols as $subcontrol => $data){
                                        foreach ($data as $key => $value) {
                                            if (!isset($statistics_of_level[$type])) $statistics_of_level[$type] = [];
                                            $statistics_of_level[$type][$key] = ($statistics_of_level[$type][$key] ?? 0) + ($data[$key]);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return $statistics_of_level;
    }

    // Páginas
    public function beginning_period_statistics(){
        try{
            $basic_ini_statistics = $this->getStatisticsOfTotalsByLevelsAndControl();
            array_splice($basic_ini_statistics,-2);
            $basic_ini_totals = $this->getStatisticsOfLevelsByControl(["Inicial (Escolarizado)", "Inicial (No escolarizado)", "Especial (CAM)", "Especial (USAER)", "Preescolar", "Primaria", "Secundaria"]);
            $high_school_totals = $this->getStatisticsOfLevelsByControl(["Media Superior"]);
            $university_statistics = $this->getStatisticsOfLevelByTypesAndControls("Superior");
            $university_totals = $this->getStatisticsOfLevelsByControl(["Superior"]);
            return view('beginning-period-statistics', ['basic_ini_statistics' => $basic_ini_statistics, 'basic_ini_totals' => $basic_ini_totals, 'high_school_totals' => $high_school_totals, 'university_statistics' => $university_statistics, 'university_totals' => $university_totals]);
        } catch (\Exception $e){
            return view('page-under-construction');
        }
    }

    public function students_teachers_gender(){
        try{
            $statistics = $this->getStatisticsOfTotalsByLevels();
            $totals = $this->getStatisticsOfTotals();
            return view('students-teachers-gender', ['statistics' => $statistics, 'totals' => $totals]);
        } catch (\Exception $e){
            return view('page-under-construction');
        }
    }
    public function students_school_level_sustenance(){
        try{
            $statistics = $this->getStatisticsOfTotalsByLevelsAndControl();
            $totals = $this->getStatisticsOfTotalsByControl();
            return view('students-school-level-sustenance', ['statistics' => $statistics, 'totals' => $totals]);
        } catch (\Exception $e){
            return view('page-under-construction');
        }
    }
    public function teachers_school_level_sustenance(){
        try{
            $statistics = $this->getStatisticsOfTotalsByLevelsAndControl();
            $totals = $this->getStatisticsOfTotalsByControl();
            return view('teachers-school-level-sustenance', ['statistics' => $statistics, 'totals' => $totals]);
        } catch (\Exception $e){
            return view('page-under-construction');
        }
    }
    public function schools_school_level_sustenance(){
        try{
            $statistics = $this->getStatisticsOfTotalsByLevelsAndControl();
            $totals = $this->getStatisticsOfTotalsByControl();
            return view('schools-school-level-sustenance', ['statistics' => $statistics, 'totals' => $totals]);
        } catch (\Exception $e){
            return view('page-under-construction');
        }
    }
    public function students_school_level_ratio(){
        try{
            $statistics = $this->getStatisticsOfTotalsByLevels();
            return view('students-school-level-ratio', compact('statistics'));
        } catch (\Exception $e){
            return view('page-under-construction');
        }
    }

    public function level_statistics($level){
        try{
            $stats1 = $this->getStatisticsOfLevelByTypesAndControls($level);
            $stats2 = $this->getStatisticsOfLevelByTypes($level);
            $stats3 = $this->getStatisticsOfLevelByMunicipalities($level);
            $stats4 = $this->getStatisticsOfLevelByMunicipalitiesAndControls($level);
            $totals1 = $this->getStatisticsOfLevelsByControl([$level]);
            $totals2 = $this->getStatisticsOfLevel($level);
            return view('level-statistics',['stats1' => $stats1, 'stats2' => $stats2, 'stats3' => $stats3, 'stats4' => $stats4, 'totals1' => $totals1, 'totals2' => $totals2, 'level' => $level]);
        } catch (\Exception $e){
            return view('page-under-construction');
        }
    }

    public function transfered_level_statistics($level){
        $subcontrol = "Federal Transferido";
        try{
            $stats1 = $this->getStatisticsOfLevelAndSubcontrolByTypes($level, $subcontrol);
            $stats2 = $this->getStatisticsOfLevelAndSubcontrolByMunicipalities($level, $subcontrol);
            $totals = $this->getStatisticsOfLevelAndSubcontrol($level, $subcontrol);
            return view('subcontrol-level-statistics',['stats1' => $stats1, 'stats2' => $stats2, 'totals' => $totals, 'level' => $level, 'subcontrol' => $subcontrol]);
        } catch (\Exception $e){
            return view('page-under-construction');
        }
    }

    public function students_high_school_type(){
        try{
            $statistics = $this->getStatisticsOfLevelByTypes("Media Superior");
            return view('students-school-type-level-degree', ['statistics' => $statistics, "title" => 'Alumnos inscritos por tipo de bachillerato']);
        } catch (\Exception $e){
            return view('page-under-construction');
        }
    }

    public function high_schools_subcontrol(){
        try{
            $level = "Media Superior";
            $statistics = $this->getStatisticsOfLevelBySubcontrol($level);
            return view('schools-sustenance-types', ['statistics'=> $statistics,'level'=> $level, "title" => "Matrícula y planteles o servicios por tipo de sostenimiento en educación Media Superior"]);
        } catch (\Exception $e){
            return view('page-under-construction');
        }
    }

    public function university_students_level_degree(){
        try{
            $statistics = $this->getStatisticsOfLevelByTypes('Superior');
            return view('students-school-type-level-degree', ["statistics" => $statistics, "title" => "Matrícula de educación superior por nivel o grado"]);
        } catch (\Exception $e){
            return view('page-under-construction');
        }
    }

    public function tsu_lic_students(){
        try{
            $statistics = $this->getStatisticsOfLevelAndTypes('Superior', ["Técnico Superior Universitario", "Licenciatura"]);
            return view('students-school-type-level-degree', ["statistics" => $statistics, "title" => "Matrícula de educación superior (TSU y Licenciatura)"]);
        } catch (\Exception $e){
            return view('page-under-construction');
        }
    }

    public function pos_students(){
        try{
            $statistics = $this->getStatisticsOfLevelAndTypes('Superior', ["Especialidad","Maestría","Doctorado"]);
            return view('students-school-type-level-degree', ["statistics" => $statistics, "title" => "Matrícula en posgrado por nivel o grado"]);
        } catch (\Exception $e){
            return view('page-under-construction');
        }
    }
    public function university_study_programs(){
        try{
            $statistics = $this->getStatisticsOfLevelByTypes('Superior');
            return view('study-programs', ["statistics" => $statistics, "title" => "Carreras de educación superior"]);
        } catch (\Exception $e){
            return view('page-under-construction');
        }
    }

    public function tsu_lic_study_programs(){
        try{
            $statistics = $this->getStatisticsOfLevelAndTypes('Superior', ["Técnico Superior Universitario", "Licenciatura"]);
            return view('study-programs', ["statistics" => $statistics, "title" => "Carreras de TSU y Licenciaturas"]);
        } catch (\Exception $e){
            return view('page-under-construction');
        }
    }

    public function pos_study_programs(){
        try{
            $statistics = $this->getStatisticsOfLevelAndTypes('Superior', ["Especialidad","Maestría","Doctorado"]);
            return view('study-programs', ["statistics" => $statistics, "title" => "Carreras / Programas de posgrado"]);
        } catch (\Exception $e){
            return view('page-under-construction');
        }
    }

    public function universities_subcontrol(){
        try{
            $level = "Superior";
            $statistics = $this->getStatisticsOfLevelBySubcontrol($level);
            return view("schools-sustenance-types", ["statistics"=> $statistics, "level" => $level, "title" => "Instituciones y matrícula por tipo de sostenimiento"] );
        } catch (\Exception $e){
            return view("page-under-construction");
        }
    }

    public function dataTable(){
        return view("data-table",["statistics" => $this->statistics]);
    }

    //Depuración de datos
    public function retrieveStatistics(){
        return $this->statistics;
    }
}
