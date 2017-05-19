<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repositories\UsersRepository;
use App\Repositories\TurmasRepository;

class TurmasController extends Controller{


    protected $usersRepo;
    protected $turmasRepo;

    public function __construct(UsersRepository $usersRepo, TurmasRepository $turmasRepo){
        $this->usersRepo = $usersRepo;
        $this->turmasRepo = $turmasRepo;
        $this->middleware('auth');
    }

    public function turmas($idUser){
        $turmas = $this->turmasRepo->getTurmasOfUser($idUser);
        if(request()->has('filter')){
            $turmas = $this->turmasRepo->getTurmasOfUserFiltered($idUser);
        }

         return view('turmas', ['turmas'=> $turmas]);
    }

    public function studentsIndex($idTurma){

        $students = $this->turmasRepo->getStudentsOfTurma($idTurma);

       if(request()->has('filter')){
             $students = $this->turmasRepo->getStudentsOfTurmaFiltered($idTurma, request('filter'));
        }

        return view('students')->with('students', $students);
    }


}  