<?php
namespace App\Repositories;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use App\Turma;

class TurmasRepository extends BaseRepository
{
  protected $modelClass = Turma::class;

  public function getTurmaByName($name, $take = null, $paginate = false){

        $query = $this->newQuery();
        $query ->where('name', '=', $name);
        $query ->orderBy('name');

      return $this->doQuery($query, $take, $paginate);
  }


  public function getStudentsOfTurma($idTurma, $take = null, $paginate = false){

        $query = $this->newQuery();
        $query ->join('turma_alunos', 'turmas.id','=','turma_alunos.idTurma');
        $query ->join('users', 'users.id','=','turma_alunos.idUser');
        $query ->select('users.id', 'users.email', 'users.name', 'users.created_at');
        $query ->where('turma_alunos.idTurma', '=', $idTurma);
        $query ->where('users.role_id', '=', 2);
        $query ->orderBy('turma_alunos.created_at');

      return $this->doQuery($query, $take, $paginate);
  }



  public function getTurmasOfUser($idUser, $take = null, $paginate = false){

        $query = $this->newQuery();
        $query ->join('turma_alunos', 'turmas.id','=','turma_alunos.idTurma');
        $query ->select('turmas.*', 'turma_alunos.idUser');
        $query ->where('turma_alunos.idUser', '=', $idUser);
       // $query ->where('turma_alunos.idTurma', '=', 'turmas.id');
        $query ->orderBy('created_at');

      return $this->doQuery($query, $take, $paginate);
  }

}
