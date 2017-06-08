<?php
namespace App\Repositories;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use App\Exercise;
use App\ExerciseSensorData;

class ExerciseSensorDatasRepository extends BaseRepository
{
  protected $modelClass = ExerciseSensorData::class;

 
  public function getExerciseTime($idExercise, $take = 1, $paginate = false){
        $query = $this->newQuery();
        $query ->where('idExercise', '=', $idExercise);
        $query ->orderBy('timestep', 'desc');
      return $this->doQuery($query, $take, $paginate);
  }


}