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

      //Retorna para a View 'turmas' todas as turmas que o utilizador(teacher) é professor
    public function turmas(){
        $idUser = Auth::user()->id;

        $turmas = $this->turmasRepo->getTurmasOfUser($idUser);
        if(request()->has('filter')){
            $turmas = $this->turmasRepo->getTurmasOfUserFiltered($idUser);
        }

         return view('turmas', ['turmas'=> $turmas]);
    }

      //Retorna todos os utilizadores(alunos) da turma recebida por parametro para a View 'students'
    public function studentsIndex($idTurma){

         $students = $this->turmasRepo->getStudentsOfTurma($idTurma);

         if(request()->has('filter')){
             $students = $this->turmasRepo->getStudentsOfTurmaFiltered($idTurma, request('filter'));
         }

        return view('students')->with('students', $students);
    }


}
