<?php
namespace App\Repositories;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use App\Turma;

class TurmasRepository extends BaseRepository
{
  protected $modelClass = Turma::class;

  public function getTurmaByName($name, $take = 6, $paginate = true){

        $query = $this->newQuery();
        $query ->where('name', '=', $name);
        $query ->orderBy('name');

      return $this->doQuery($query, $take, $paginate);
  }


  public function getStudentsOfTurma($idTurma, $take = 6, $paginate = true){

        $query = $this->newQuery();
        $query ->join('turma_alunos', 'turmas.id','=','turma_alunos.idTurma');
        $query ->join('users', 'users.id','=','turma_alunos.idUser');
        $query ->select('users.id', 'users.email', 'users.name', 'users.created_at');
        $query ->where('turma_alunos.idTurma', '=', $idTurma);
        $query ->where('users.role_id', '=', 2);
        $query ->orderBy('turma_alunos.created_at');

      return $this->doQuery($query, $take, $paginate);
  }


  public function getStudentsOfTurmaFiltered($idTurma, $filter, $take = 6, $paginate = true){
        $by = 'users.name';
        if(strpos($filter, '@')!== false){
          $by = 'users.email';
        }

        $query = $this->newQuery();
        $query ->join('turma_alunos', 'turmas.id','=','turma_alunos.idTurma');
        $query ->join('users', 'users.id','=','turma_alunos.idUser');
        $query ->select('users.id', 'users.email', 'users.name');
        $query ->where('turma_alunos.idTurma', '=', $idTurma);
        $query ->where('users.role_id', '=', 2);
         $query ->where($by, 'LIKE', '%'.request('filter').'%');
        $query ->orderBy('turma_alunos.created_at');

      return $this->doQuery($query, $take, $paginate);
  }

  public function getTurmasOfUser($idUser, $take = 6, $paginate = true){

        $query = $this->newQuery();
        $query ->join('turma_alunos', 'turmas.id','=','turma_alunos.idTurma');
        $query ->select('turmas.*', 'turma_alunos.idUser');
        $query ->where('turma_alunos.idUser', '=', $idUser);
       // $query ->where('turma_alunos.idTurma', '=', 'turmas.id');
        $query ->orderBy('created_at');

      return $this->doQuery($query, $take, $paginate);
  }

   public function getTurmasOfUserFiltered($idUser, $take = 6, $paginate = true){
        $query = $this->newQuery();
        $query ->join('turma_alunos', 'turmas.id','=','turma_alunos.idTurma');
        $query ->select('turmas.*', 'turma_alunos.idUser');
        $query ->where('turma_alunos.idUser', '=', $idUser);
        $query ->where('turmas.name', 'LIKE', '%'.request('filter').'%');
        $query ->orderBy('created_at');

      return $this->doQuery($query, $take, $paginate);
   }

}
