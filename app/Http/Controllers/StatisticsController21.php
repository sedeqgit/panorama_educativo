<?php

namespace App\Http\Controllers;

class StatisticsController21 extends StatisticsControllerBase
{
    public function __construct(){
        $this->initializeDBVariables(21);
        $this->queries_data_structure=[
            "Inicial (Escolarizado)" => [
                "General" => [
                    $this->ini_gral => [
                        "school_count" => "cv_cct",
                        "male_students" => "V390+V406",
                        "female_students" => "V394+V410",
                        "male_teachers" => "V509+V516+V523+V511+V518+V525",
                        "female_teachers" => "V510+V517+V524+V512+V519+V526",
                        "groups" => "V402+V418"
                    ]
                ],
                "gral_dir"=> [
                    $this->ini_gral => [
                        "school_count" => "0",
                        "male_students" => "0",
                        "female_students" => "0",
                        "male_teachers" => "V785",
                        "female_teachers" => "V786",
                        "groups" => "0"
                    ]
                ],
                "Indígena"=> [
                    $this->ini_ind => [
                        "school_count" => "cv_cct",
                        "male_students" => "V183",
                        "female_students" => "V184",
                        "male_teachers" => "V211",
                        "female_teachers" => "V212",
                        "groups" => "0"
                    ]
                ]
            ],
            "Inicial (No escolarizado)"=> [
                "ne"=> [
                    $this->ini_ne => [
                        "school_count" => "cv_cct",
                        "male_students" => "V370",
                        "female_students" => "V371",
                        "male_teachers" => "V427",
                        "female_teachers" => "V428",
                        "groups" => "V143"
                    ]
                ]
            ],
            "Especial (CAM)"=> [
                "total" => [
                    $this->esp_cam => [
                        "school_count" => "cv_cct",
                        "male_students" => "V2255",
                        "female_students" => "V2256",
                        "male_teachers" => "V2311+V2319+V2327+V2335+V2343+V2351+V2359+V2367+V2375+V2383+V2391+V2399+V2407+V2415+V2423+V2431+V2440+V2449+V2458+V2467+V2476+V2485+V2494",
                        "female_teachers" => "V2312+V2320+V2328+V2336+V2344+V2352+V2360+V2368+V2376+V2384+V2392+V2400+V2408+V2416+V2424+V2432+V2441+V2450+V2459+V2468+V2477+V2486+V2495",
                        "groups" => "V1343+V1418+V1511+V1586+V1765"
                    ]
                ]
            ],
            "Especial (USAER)"=> [
                "total"=> [
                    $this->esp_usaer => [
                        "school_count" => "cv_cct",
                        "male_students" => "V2814+V2816+V2818+V2820",
                        "female_students" => "V2815+V2817+V2819+V2821",
                        "male_teachers" => "V2973",
                        "female_teachers" => "V2974",
                        "groups" => "0"
                    ]
                    ],
                "doc" => [
                    $this->esp_usaer => [
                        "school_count" => "0",
                        "male_students" => "0",
                        "female_students" => "0",
                        "male_teachers" => "V2835",
                        "female_teachers" => "V2836",
                        "groups" => "0"
                    ]
                ]
            ],
            "Preescolar" => [
                "General" => [
                    $this->ini_gral => [
                        "school_count" => "SUM(0)",
                        "male_students" => "V466",
                        "female_students" => "V472",
                        "male_teachers" => "V513+V520+V527",
                        "female_teachers" => "V514+V521+V528",
                        "groups" => "V479"
                    ],
                    $this->pree_gral => [
                        "school_count" => "COUNT(cv_cct)",
                        "male_students" => "V165",
                        "female_students" => "V171",
                        "male_teachers" => "V859+V867",
                        "female_teachers" => "V860+V868",
                        "groups" => "V182"
                    ]
                ],
                "Comunitario"=> [
                    $this->pree_comuni => [
                        "school_count" => "cv_cct",
                        "male_students" => "V85",
                        "female_students" => "V91",
                        "male_teachers" => "V149",
                        "female_teachers" => "V150",
                        "groups" => "COUNT(cv_cct)-SUM(V78)"
                    ]
                ],
                "Indígena" => [
                    $this->pree_ind => [
                        "school_count" => "cv_cct",
                        "male_students" => "V165",
                        "female_students" => "V171",
                        "male_teachers" => "V795+V803",
                        "female_teachers" => "V796+V804",
                        "groups" => "V182"
                    ]
                ]
            ],
            "Primaria" => [
                "General" => [
                    $this->prim_gral => [
                        "school_count" => "cv_cct",
                        "male_students" => "V562+V573",
                        "female_students" => "V585+V596",
                        "male_teachers" => "V1575+V1567",
                        "female_teachers" => "V1576+V1568",
                        "groups" => "V616"
                    ]
                ],
                "Comunitario" => [
                    $this->prim_comuni => [
                        "school_count" => "cv_cct",
                        "male_students" => "V469+V480",
                        "female_students" => "V492+V503",
                        "male_teachers" => "V583",
                        "female_teachers" => "V584",
                        "groups" => "COUNT(cv_cct)"
                    ]
                ],
                "Indígena" => [
                    $this->prim_ind => [
                        "school_count" => "cv_cct",
                        "male_students" => "V564+V575",
                        "female_students" => "V587+V598",
                        "male_teachers" => "V1507+V1499",
                        "female_teachers" => "V1508+V1500",
                        "groups" => "V1052"
                    ]
                ]
            ],
            "Secundaria" => [
                "General" => [
                    $this->sec_gral => [
                        "school_count" => "cv_cct",
                        "male_students" => "V306+V314",
                        "female_students" => "V323+V331",
                        "male_teachers" => "V1297+V1303+V1307+V1309+V1311+V1313",
                        "female_teachers" => "V1298+V1304+V1308+V1310+V1312+V1314",
                        "groups" => "V341"
                    ]
                ],
                "Telesecundaria" => [
                    $this->sec_gral => [
                        "school_count" => "cv_cct",
                        "male_students" => "V306+V314",
                        "female_students" => "V323+V331",
                        "male_teachers" => "V1297+V1303+V1307+V1309+V1311+V1313",
                        "female_teachers" => "V1298+V1304+V1308+V1310+V1312+V1314",
                        "groups" => "V341"
                    ]
                ],
                "tec" => [
                    $this->sec_gral => [
                        "school_count" => "cv_cct",
                        "male_students" => "V306+V314",
                        "female_students" => "V323+V331",
                        "male_teachers" => "V1297+V1303+V1307+V1309+V1311+V1313",
                        "female_teachers" => "V1298+V1304+V1308+V1310+V1312+V1314",
                        "groups" => "V341"
                    ]
                ],
                "Comunitario" => [
                    $this->sec_comuni => [
                        "school_count" => "cv_cct",
                        "male_students" => "V223+V231",
                        "female_students" => "V240+V248",
                        "male_teachers" => "V384",
                        "female_teachers" => "V385",
                        "groups" => "COUNT(cv_cct)"
                    ]
                ]
            ],
            "Media Superior"=> [
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
            ],
            "Superior"=> [
                "Técnico Superior Universitario" => [
                    $this->sup_carrera => [
                        "school_count" => "cct_ins_pla",
                        "male_students" => "V175",
                        "female_students" => "V176",
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
                        "male_teachers" => "V81",
                        "female_teachers" => "V82",
                        "groups" => "0"
                    ]
                ]
            ]
        ];

        $this->queries_rules = [
            "Inicial (Escolarizado)"=> [
                "General" => function($q){
                    $q->whereIn("cv_estatus_captura", [0,10]);
                },
                "gral_dir" => function($q){
                    $q->whereIn("cv_estatus_captura", [0,10])->where("v478",">","0");
                },
                "Indígena" => function($q){
                    $q->whereIn("cv_estatus_captura", [0,10]);
                }
            ],
            "Inicial (No escolarizado)"=> [
                "ne" => function($q){
                    $q->whereIn("cv_estatus_captura", [0,10]);
                }
            ],
            "Especial (CAM)"=> [
                "total" => function($q){
                    $q->whereIn("cv_estatus_captura", [0]);
                }
            ],
            "Especial (USAER)"=> [
                "total" => function($q){
                    $q->whereIn("cv_estatus_captura", [0,10]);
                },
                "doc"=> function($q){
                    $q->whereIn("cv_estatus_captura", [0,10])->where("v2828","=","1");
                }
            ],
            "Preescolar" => [
                "General" => function($q) {
                    if($q->from == $this->ini_gral){
                        $q->whereIn("cv_estatus_captura", [0,10])->where("V478",">","0");
                    }else{
                        $q->whereIn("cv_estatus_captura", [0,10]);
                    }
                },
                "Comunitario" => function($q) {
                    $q->whereIn("cv_estatus_captura", [0,10]);
                },
                "Indígena" => function($q) {
                    $q->whereIn("cv_estatus_captura", [0,10]);
                }
            ],
            "Primaria" => [
                "General" => function($q) {
                    $q->whereIn("cv_estatus_captura", [0,10]);
                },
                "Comunitario" => function($q) {
                    $q->whereIn("cv_estatus_captura", [0,10]);
                },
                "Indígena" => function($q) {
                    $q->whereIn("cv_estatus_captura", [0,10]);
                }
            ],
            "Secundaria" => [
                "General" => function($q) {
                    $q->whereIn("cv_estatus_captura", [0,10])->where("subnivel","=","GENERAL");
                },
                "Telesecundaria" => function($q) {
                    $q->whereIn("cv_estatus_captura", [0,10])->where("subnivel","=","TELESECUNDARIA");
                },
                "tec" => function($q) {
                    $q->whereIn("cv_estatus_captura", [0,10])->where("subnivel","<>","GENERAL")->where("subnivel","<>","TELESECUNDARIA");
                },
                "Comunitario" => function($q) {
                    $q->whereIn("cv_estatus_captura", [0,10]);
                }
            ],
            "Media Superior" => [
                "General" => function($q) {
                    $q->where("cv_motivo","=","0")->whereNotIn("cv_estatus", [2,4]);
                },
                "Tecnológico" => function($q) {
                    $q->where("cv_motivo","=","0")->whereNotIn("cv_estatus", [2,4]);
                }
            ],
            "Superior" => [
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
            ]
        ];
        $this->loadStatistics();
    }

    public function sample_charts(){
        return view('sample-charts');
    }
}
