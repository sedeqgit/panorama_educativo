<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HistoricalStatisticsController extends Controller
{
    private array $data = [];

    public function __construct(){
        $this->data = [
            "2021-2022" => StatisticsController21
        ];
    }

    public function index(){
        return $this->data;
    }
}
