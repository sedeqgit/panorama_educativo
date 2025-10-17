<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HighSchoolStatisticsController21 extends HighSchoolStatisticsControllerBase
{
    public function __construct(){
        $this->initializeDBVariables(21);
        $this->queries_data_structure=[
            "General" => [
                $this->ms_gral => [
                    "school_count" => "distinct cct_ins_pla",
                    "male_students" => "V395",
                    "female_students" => "V396",
                    "male_teachers" => "V958",
                    "female_teachers" => "V959",
                    "groups" => "V401"
                ]
            ],
            "Tecnológico"=> [
                $this->ms_tecno => [
                    "school_count" => "distinct cct_ins_pla",
                    "male_students" => "V470",
                    "female_students" => "V471",
                    "male_teachers" => "V1057",
                    "female_teachers" => "V1058",
                    "groups" => "V476"
                ]
            ]
        ];

        $this->queries_rules = [
            "General" => function($q) {
                $q->where("cv_motivo","=","0")->whereNotIn("cv_estatus", [2,4]);
            },
            "Tecnológico" => function($q) {
                $q->where("cv_motivo","=","0")->whereNotIn("cv_estatus", [2,4]);
            }
        ];
        $this->loadStatistics();
    }
}
