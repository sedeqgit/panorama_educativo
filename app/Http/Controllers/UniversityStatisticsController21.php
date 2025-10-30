<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UniversityStatisticsController21 extends UniversityStatisticsControllerBase
{
    public function __construct(){
        $this->initializeDBVariables(21);
        $this->queries_data_structure=[
            "Técnico Superior Universitario" => [
                $this->sup_carrera => [
                    "school_count" => "cct_ins_pla",
                    "male_students" => "V175",
                    "female_students" => "V176",
                    "new_male_students" => "V21",
                    "new_female_students" => "V22",
                    "graduate_male_students" => "V73",
                    "graduate_female_students" => "V74",
                    "male_teachers" => "0",
                    "female_teachers" => "0",
                    "carriers" => "cv_carrera",
                    "groups" => "0"
                ]
            ],
            "Licenciatura" => [
                $this->sup_carrera => [
                    "school_count" => "cct_ins_pla",
                    "male_students" => "V175",
                    "female_students" => "V176",
                    "new_male_students" => "V21",
                    "new_female_students" => "V22",
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
            ],
            "Escuelas"=> [
                $this->sup_escuela => [
                    "school_count"=> "DISTINCT cct_ins_pla",
                    "male_students" => "0",
                    "female_students" => "0",
                    "new_male_students" => "0",
                    "new_female_students" => "0",
                    "graduate_male_students" => "0",
                    "graduate_female_students" => "0",
                    "male_teachers" => "V81",
                    "female_teachers" => "V82",
                    "groups" => "0"
                ]
            ]
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
            "Técnico Superior Universitario" => function($q) {
                $q->where("cv_motivo","=","0")->where("cv_carrera","LIKE","4%");
            },
            "Licenciatura" => function($q) {
                $q->where("cv_motivo","=","0")->where("cv_carrera","LIKE","5%");
            },
            "Especialidad" => function($q) {
                $q->where("cv_motivo","=","0")->where("cv_carrera","LIKE","6%");
            },
            "Maestría" => function($q) {
                $q->where("cv_motivo","=","0")->where("cv_carrera","LIKE","7%");
            },
            "Doctorado" => function($q) {
                $q->where("cv_motivo","=","0")->where("cv_carrera","LIKE","8%");
            },
            "Escuelas" => function($q) {
                $q->where("cv_motivo","=","0");
            }
        ];
        $this->loadStatistics();
    }
}
