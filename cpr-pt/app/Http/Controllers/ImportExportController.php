<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Maatwebsite\Excel\Facades\Excel;


class ImportExportController extends Controller
{

    public function import(){
        $results = Excel::load('cpr_turma_alunos.csv', function($reader) {
            $reader->select(array('name'));
        }, 'UTF-8')->get();

        $data=array("results"=>$results);
        return json_encode($data);
    }
}
