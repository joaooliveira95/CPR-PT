<?php
namespace App\Repositories;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use App\Exercise;

class ExercisesRepository extends BaseRepository
{
  protected $modelClass = Exercise::class;

  public function getSessionExercises($idSession, $take = 6, $paginate = false){
        $query = $this->newQuery();
        $query ->where('idSession', '=', $idSession);

      return $this->doQuery($query, $take, $paginate);
  }

    public function getUserExercises($idUser, $take = 6, $paginate = false){
        $query = $this->newQuery();
        $query ->join('sessions', 'sessions.id', '=', 'exercises.idSession');
        $query ->join('users', 'users.id', '=', 'sessions.idUser');
        $query ->select('exercises.*', 'users.name', 'sessions.title');
        $query ->where('users.id', '=', $idUser);

      return $this->doQuery($query, $take, $paginate);
  }


}