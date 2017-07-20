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
   public function number_students($idTurma){
      $n_students = $this->turmasRepo->getStudentsOfTurma($idTurma)->count();
       return $n_students;
   }

    public function turmas(){
        $idUser = Auth::user()->id;
        $turmas = $this->turmasRepo->getTurmasOfUser($idUser);
         $num_alunos = array();
        foreach ($turmas as $turma) {
           $idTurma = $turma->id;
           $num_alunos[''.$idTurma.''] = $this->number_students($idTurma);
        }
         return view('turmas', ['turmas'=> $turmas, 'num_alunos'=>$num_alunos]);
    }

      //Retorna todos os utilizadores(alunos) da turma recebida por parametro para a View 'students'
    public function studentsIndex($idTurma){
         $students = $this->turmasRepo->getStudentsOfTurma($idTurma);

        return view('students')->with('students', $students);
    }


}
