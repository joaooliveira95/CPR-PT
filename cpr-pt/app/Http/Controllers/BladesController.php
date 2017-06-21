<?php

namespace App\Http\Controllers;

use Auth;
use DateTime;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repositories\UsersRepository;
use App\Repositories\SessionsRepository;
use App\Repositories\ExercisesRepository;

class BladesController extends Controller{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    protected $sessionsRepo;
    protected $usersRepo;

    public function __construct(UsersRepository $usersRepo, SessionsRepository $sessionsRepo, ExercisesRepository $exercisesRepo){
        $this->usersRepo = $usersRepo;
        $this->sessionsRepo = $sessionsRepo;
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function studentsIndex(){

        if(request()->has('filter')){
             $students = $this->usersRepo->filterStudents(request('filter'));
            return view('students')->with('students', $students);
        }

        $students = $this->usersRepo->getUsersByRole('2');

        return view('students')->with('students', $students);
    }

    public function contentIndex(){
        return view('content');
    }

}  