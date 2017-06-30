<?php

namespace App\Http\Controllers;

use Auth;
use DateTime;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class BladesController extends Controller{
    /**
     * Create a new controller instance.
     *
     * @return void
     */


    public function __construct(){
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */


    public function contentIndex(){
        return view('content');
    }

    public function discussion(){
        return view('discussion');
    }

}
