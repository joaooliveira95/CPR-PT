<?php

namespace App\Http\Controllers;

use Auth;
use DateTime;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;


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
     public function homeIndex(){
      return Cache::rememberForever('home', function() {
          return View::make('home')
                ->render();
      });
     }


   public function createSessionIndex(){
      return Cache::rememberForever('createSession', function() {
          return View::make('createSession')
                ->render();
      });
   }

    public function contentIndex(){
        return Cache::remember('content', 10, function() {
             return View::make('content')
                 ->render();
         });
    }

    public function discussionIndex(){
      return Cache::remember('discussion', 10, function() {
           return View::make('discussion')
                ->render();
       });
    }



}
