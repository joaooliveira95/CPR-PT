<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repositories\UsersRepository;
use App\Repositories\SessionsRepository;
use App\Repositories\ExercisesRepository;
use Yajra\Datatables\Facades\Datatables;

class SessionsController extends Controller{

    protected $sessionsRepo;
    protected $exercisesRepo;
    protected $usersRepo;

    public function __construct(UsersRepository $usersRepo, SessionsRepository $sessionsRepo, ExercisesRepository $exercisesRepo){
        $this->usersRepo = $usersRepo;
        $this->sessionsRepo = $sessionsRepo;
        $this->exercisesRepo = $exercisesRepo;
        $this->middleware('auth');

    }

//Retorna a view Sessions.blade com todas as sessões do utilizador com
// o id recebido por parametro
    public function sessions($idUser){
      $sessions = $this->sessionsRepo->getUserSessions($idUser);
      $user = User::find($idUser);

      return view('sessions', ['sessions'=> $sessions, 'user' => $user]);
  }

//Retorna a view Session.blade da sessão com o id recebido por parametro
    public function session($idSession){
        $session = $this->sessionsRepo->findByID($idSession);
        $user = $this->usersRepo->findByID($session->idUser);
        $exercises = $this->exercisesRepo->getSessionExercises($idSession);

        return view('session', ['session' => $session, 'user' => $user, 'exercises' => $exercises]);
    }

    public function progressIndex($idUser){
         $user = User::find($idUser);
         return view('progress', ['user'=> $user]);
    }

    public function progress($idSession){
        $exercises = $this->exercisesRepo->getSessionExercises($idSession);
        $recoil = $compress = $hands = array();
        $cnt = count($exercises);

        for($i=0;$i<$cnt;$i++){
            $time[$i] = $exercises[$i]->time;
            $recoil[$i] = $exercises[$i]->recoil;
            $compress[$i]= $exercises[$i]->compressions;
            $hands[$i]= $exercises[$i]->hand_position; //$hands[$i]= rand(0,100);
        }

        $data=array("time"=>$time, "recoil"=>$recoil,"compress"=>$compress, "hands"=>$hands);
        return json_encode($data);
    }

    public function userExercises($idUser){
        $exercises = $this->exercisesRepo->getUserExercises($idUser);
        $recoil = $compress = $hands = $dates = $time = array();
        $cnt = count($exercises);

        for($i=0;$i<$cnt;$i++){
            $time[$i] = $exercises[$i]->time;
            $recoil[$i] = $exercises[$i]->recoil;
            $compress[$i]= $exercises[$i]->compressions;
            $dates[$i]= (string) $exercises[$i]->created_at->format('d/m/y h:i:s');
            $hands[$i]= $exercises[$i]->hand_position;
        }

        $data=array("time"=>$time, "recoil"=>$recoil,"compress"=>$compress, "hands"=>$hands, "dates"=>$dates);
        return json_encode($data);
    }

    public function exercise($idExercise){

         $exercise = $this->exercisesRepo->findByID($idExercise);
         return view("exercise_feedback", ['exercise' => $exercise]);
    }
}
