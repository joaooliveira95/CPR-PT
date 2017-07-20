<?php
namespace App\Repositories;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use App\Exercise;

class ExercisesRepository extends BaseRepository
{
  protected $modelClass = Exercise::class;

  public function getSessionExercises($idSession, $take = null, $paginate = true){
        $query = $this->newQuery();
        $query ->where('idSession', '=', $idSession);

      return $this->doQuery($query, $take, $paginate);
  }

    public function getUserExercises($idUser, $take = null, $paginate = false){

        $query = $this->newQuery();
        $query ->join('sessions', 'sessions.id', '=', 'exercises.idSession');
        $query ->join('users', 'users.id', '=', 'sessions.idUser');
        $query ->select('exercises.*');
        $query ->where('users.id', '=', $idUser);
        $query ->orderBy('sessions.created_at', 'desc');
      return $this->doQuery($query, $take, $paginate);
  }


}
