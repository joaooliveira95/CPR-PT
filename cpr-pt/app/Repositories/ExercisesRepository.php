<?php
namespace App\Repositories;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use App\Exercise;

class ExercisesRepository extends BaseRepository
{
  protected $modelClass = Exercise::class;

  public function getSessionExercises($idSession, $take = 8, $paginate = true){
        $query = $this->newQuery();
        $query ->where('idSession', '=', $idSession);

      return $this->doQuery($query, $take, $paginate);
  }

}