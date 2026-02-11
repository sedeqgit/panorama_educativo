<?php

namespace App\Http\Controllers\UniversityStatistics;

use Illuminate\Http\Request;

class Controller18 extends Base
{
    public function __construct(){
        $this->initializeDBVariables(18);
        $this->queries_data_structure=[
            "Técnico Superior Universitario" => [
                $this->sup_carrera => [
                    "school_count" => "cct_ins_pla",
                    "male_students" => "V175",
                    "female_students" => "V176",
                    "new_male_students" => "V88",
                    "new_female_students" => "V89",
                    "graduate_male_students" => "V73",
                    "graduate_female_students" => "V74",
                    "male_teachers" => "V81",
                    "female_teachers" => "V82",
                    "carriers" => "cv_carrera",
                    "groups" => "0"
                ]
            ],
            "Licenciatura" => [
                $this->sup_carrera => [
                    "school_count" => "cct_ins_pla",
                    "male_students" => "V175",
                    "female_students" => "V176",
                    "new_male_students" => "V88",
                    "new_female_students" => "V89",
                    "graduate_male_students" => "V73",
                    "graduate_female_students" => "V74",
                    "male_teachers" => "0",
                    "female_teachers" => "0",
                    "carriers" => "cv_carrera",
                    "groups" => "0"
                ]
            ],
            "Especialidad" => [
                $this->sup_posgrado => [
                    "school_count" => "cct_ins_pla",
                    "male_students" => "V140",
                    "female_students" => "V141",
                    "new_male_students" => "V47",
                    "new_female_students" => "V48",
                    "graduate_male_students" => "V25",
                    "graduate_female_students" => "V26",
                    "male_teachers" => "0",
                    "female_teachers" => "0",
                    "carriers" => "cv_carrera",
                    "groups" => "0"
                ]
            ],
            "Maestría" => [
                $this->sup_posgrado => [
                    "school_count" => "cct_ins_pla",
                    "male_students" => "V140",
                    "female_students" => "V141",
                    "new_male_students" => "V47",
                    "new_female_students" => "V48",
                    "graduate_male_students" => "V25",
                    "graduate_female_students" => "V26",
                    "male_teachers" => "0",
                    "female_teachers" => "0",
                    "carriers" => "cv_carrera",
                    "groups" => "0"
                ]
            ],
            "Doctorado" => [
                $this->sup_posgrado => [
                    "school_count" => "cct_ins_pla",
                    "male_students" => "V140",
                    "female_students" => "V141",
                    "new_male_students" => "V47",
                    "new_female_students" => "V48",
                    "graduate_male_students" => "V25",
                    "graduate_female_students" => "V26",
                    "male_teachers" => "0",
                    "female_teachers" => "0",
                    "carriers" => "cv_carrera",
                    "groups" => "0"
                ]
            ]
        ];

        $this->query_data_structure_for_schools_details = [
            "male_teachers" => "V81",
            "female_teachers" => "V82"
        ];

        $this->queries_data_structure_by_schools = [
            "Técnico Superior Universitario" => [
                $this->sup_carrera => [
                    "school_name" => "nombre_ins_pla",
                    "male_students" => "V175",
                    "female_students" => "V176",
                ]
            ],
            "Licenciatura" => [
                $this->sup_carrera => [
                    "school_name" => "nombre_ins_pla",
                    "male_students" => "V175",
                    "female_students" => "V176",
                ]
            ],
            "Especialidad" => [
                $this->sup_posgrado => [
                    "school_name" => "nombre_ins_pla",
                    "male_students" => "V140",
                    "female_students" => "V141",
                ]
            ],
            "Maestría" => [
                $this->sup_posgrado => [
                    "school_name" => "nombre_ins_pla",
                    "male_students" => "V140",
                    "female_students" => "V141",
                ]
            ],
            "Doctorado" => [
                $this->sup_posgrado => [
                    "school_name" => "nombre_ins_pla",
                    "male_students" => "V140",
                    "female_students" => "V141",
                ]
            ]
        ];

        $this->queries_rules = [
            "Técnico Superior Universitario" => function($q,$fc="%") {
                $q->where("cv_motivo","=","0")->where("cv_carrera","LIKE","4".$fc);
            },
            "Licenciatura" => function($q,$fc="%") {
                $q->where("cv_motivo","=","0")->where("cv_carrera","LIKE","5".$fc);
            },
            "Especialidad" => function($q,$fc="%") {
                $q->where("cv_motivo","=","0")->where("cv_carrera","LIKE","6".$fc);
            },
            "Maestría" => function($q,$fc="%") {
                $q->where("cv_motivo","=","0")->where("cv_carrera","LIKE","7".$fc);
            },
            "Doctorado" => function($q,$fc="%") {
                $q->where("cv_motivo","=","0")->where("cv_carrera","LIKE","8".$fc);
            }
        ];
        $this->loadStatistics();
    }
}
