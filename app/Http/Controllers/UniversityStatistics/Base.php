<?php

namespace App\Http\Controllers\UniversityStatistics;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Base extends Controller
{
    // Variables de estructura y traducción de bases de datos
    protected array $queries_data_structure, $queries_rules;
    protected array $queries_data_structure_by_schools;

    // Variables de estadísticas
    private array $statistics, $statistics_by_institutions;
    private array $school_count;

    // Variables de bases de datos
    // Esquema de la base de datos
    private $database_schema;

    // Varibles de nivel
    protected $sup_carrera, $sup_escuela, $sup_posgrado;

    protected function initializeDBVariables($cycle){
        $this->database_schema = "nonce_pano_".$cycle;
        $this->sup_carrera = ".sup_carrera_".$cycle;
        $this->sup_posgrado = ".sup_posgrado_".$cycle;
        $this->sup_escuela = ".sup_escuela_".$cycle;
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
        $fields=[
            "Educación",
            "Artes y humanidades",
            "Ciencias sociales y derecho",
            "Administración y negocios",
            "Ciencias naturales, matemáticas y estadística",
            "Tecnologías de la información y la comunicación",
            "Ingeniería, manufactura y construcción",
            "Agronomía y veterinaria",
            "Ciencias de la salud",
            "Servicios"
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
            foreach ($this->queries_data_structure as $type => $tablenames) {
                foreach ($tablenames as $tablename => $colsmap) {
                    $type_condition=$this->queries_rules[$type];
                    foreach ($fields as $field_id => $field){
                        $query = DB::table($this->database_schema.$tablename);
                        $selects = [];
                        foreach ($colsmap as $col => $colname) {
                            if ($col=="school_count" || $col=="carriers"){
                                $selects[] = DB::raw("COUNT($colname) AS $col");
                            } else{
                                $selects[] = DB::raw("SUM($colname) AS $col");
                            }
                        }
                        $schools=DB::table($this->database_schema.$this->sup_escuela)->where("cv_mun","=",($i+1))->where("cv_motivo","=","0")->pluck("cct_ins_pla")->values()->toArray();
                        $this->school_count[$municipality] = count($schools);
                        if ($tablename==$this->sup_escuela){
                            $query->where("cv_mun","=",($i+1))->where($type_condition($query));
                        } else {
                            if ($field>9) $field_carrier="%0". $field_id+1 ."%";
                            else $field_carrier="%". $field_id+1 ."%";
                            $query->where("cv_mun","=",($i+1))->where($type_condition($query))->where("cv_carrera", "LIKE",$field_carrier);
                        }
                        $data = $query->select($selects)->first();
                        if (!isset($this->statistics[$municipality])) $this->statistics[$municipality] = [];
                        if (!isset($this->statistics[$municipality][$type])) $this->statistics[$municipality][$type] = [];
                        if (!isset($this->statistics[$municipality][$type][$field])) $this->statistics[$municipality][$type][$field] = [];
                        foreach ($colsmap as $col => $colname) {
                            $this->statistics[$municipality][$type][$field][$col] = ($this->statistics[$municipality][$type][$field][$col] ?? 0) + ($data->$col);
                        }
                    }
                }
            }
        }
        foreach ($this->queries_data_structure_by_schools as $type => $tablenames) {
            foreach ($tablenames as $tablename => $colsmap) {
                $type_condition=$this->queries_rules[$type];
                foreach ($controls_queries_rules as $control => $subcontrols) {
                    foreach ($subcontrols as $subcontrol => $subcontrol_condition) {
                        $query = DB::table($this->database_schema.$tablename);
                        $selects = [];
                        foreach ($colsmap as $col => $colname) {
                            if ($col=="school_name"){
                                $selects[] = DB::raw("$colname AS $col");
                            } else{
                                $selects[] = DB::raw("SUM($colname) AS $col");
                            }
                        }
                        $query->where($type_condition($query))->where($subcontrol_condition)->groupBy("nombre_ins_pla");
                        $data = $query->select($selects)->get()->toArray();
                        if (!isset($this->statistics_by_institutions[$type])) $this->statistics_by_institutions[$type] = [];
                        $institution=null;
                        foreach ($data as $school){
                            foreach ($colsmap as $col => $colname){
                                if ($col=='school_name'){
                                    $institution = ($school->$col);
                                    $this->statistics[$type][$institution] = [];
                                } else{
                                    $this->statistics_by_institutions[$type][$institution]['students'] = ($this->statistics_by_institutions[$type][$institution]['students'] ?? 0) + ($school->$col);
                                }
                            }
                            $this->statistics_by_institutions[$type][$institution]['sustenance'] = $subcontrol;
                        }
                    }
                }
            }
        }
    }

    private function getStatisticsOfTypesByTrainingFields(array $types_to_look_up){
        $totals_by_field = [];
        foreach ($this->statistics as $municipality => $types) {
            foreach ($types as $type => $fields){
                foreach ($types_to_look_up as $type_to_look_up){
                    if ($type==$type_to_look_up){
                        foreach ($fields as $field => $data) {
                            foreach ($data as $key => $value) {
                                if (!isset($totals_by_field[$field])) $totals_by_field[$field] = [];
                                $totals_by_field[$field][$key] = ($totals_by_field[$field][$key] ?? 0) + ($value);
                            }
                        }
                    }
                }
            }
        }
        return $totals_by_field;
    }

    private function getStatisticsByInstitutions(){
        $statistics_by_institutions = [];
        foreach ($this->statistics_by_institutions as $type => $institutions){
            foreach ($institutions as $institution => $data){
                foreach ($data as $key => $value){
                    if(!isset($statistics_by_institutions[$institution])) $statistics_by_institutions[$institution] = [];
                    if($key=="sustenance"){
                        $statistics_by_institutions[$institution][$key] = $value;
                    }else{
                        $statistics_by_institutions[$institution][$key] = ($statistics_by_institutions[$institution][$key] ?? 0) + ($value);
                    }
                }
            }
        }
        return $statistics_by_institutions;
    }

    private function getStatisticsOfTypesByInstitutions(array $types_to_look_up){
        $statistics_by_institutions = [];
        foreach ($this->statistics_by_institutions as $type => $institutions){
            foreach ($types_to_look_up as $type_to_look_up){
                if ($type==$type_to_look_up){
                    foreach ($institutions as $institution => $data){
                        foreach ($data as $key => $value){
                            if(!isset($statistics_by_institutions[$institution])) $statistics_by_institutions[$institution] = [];
                            if($key=="sustenance"){
                                $statistics_by_institutions[$institution][$key] = $value;
                            }else{
                                $statistics_by_institutions[$institution][$key] = ($statistics_by_institutions[$institution][$key] ?? 0) + ($value);
                            }
                        }
                    }
                }
            }
        }
        return $statistics_by_institutions;
    }

    public function tsu_lic_carriers_students_new_graduate(){
        try{
            $statistics = $this->getStatisticsOfTypesByTrainingFields(["Técnico Superior Universitario", "Licenciatura"]);
            return view('carriers-students-new-graduate', ['statistics' => $statistics, 'type' => "TSU y Licenciatura"]);
        } catch (\Exception $e){
            return view('page-under-construction');
        }
    }

    public function pos_carriers_students_new_graduate(){
        try{
            $statistics = $this->getStatisticsOfTypesByTrainingFields(["Especialidad","Maestría","Doctorado"]);
            return view('carriers-students-new-graduate', ['statistics' => $statistics, 'type' => "Posgrado"]);
        } catch (\Exception $e){
            return view('page-under-construction');
        }
    }

    public function higher_enrollment_institutions(){
        try{
            $statistics = $this->getStatisticsByInstitutions();
            return view('higher-enrollment-institutions',['statistics' => $statistics, 'limit' => 15, 'types' => ""]);
        } catch (\Exception $e){
            return view('page-under-construction');
        }
    }

    public function tsu_lic_higher_enrollment_institutions(){
        try{
            $statistics = $this->getStatisticsOfTypesByInstitutions(["Técnico Superior Universitario", "Licenciatura"]);
            return view('higher-enrollment-institutions',['statistics' => $statistics, 'limit' => 10, 'types' => "(TSU y Licenciatura)"]);
        } catch (\Exception $e){
            return view('page-under-construction');
        }
    }

    public function pos_higher_enrollment_institutions(){
        try{
            $statistics = $this->getStatisticsOfTypesByInstitutions(["Especialidad","Maestría","Doctorado"]);
            return view('higher-enrollment-institutions',['statistics' => $statistics, 'limit' => 10, 'types' => "(Posgrado)"]);
        } catch (\Exception $e){
            return view('page-under-construction');
        }
    }
}
