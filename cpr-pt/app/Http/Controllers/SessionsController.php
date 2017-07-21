<?php

namespace App\Http\Controllers;

use Auth;
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

   public function sessions_datatable($idUser){
      return Datatables::of(DB::table('sessions')->where('idUser','=',$idUser)->get())->make(true);
   }

    public function sessions($idUser){
      $sessions = $this->sessionsRepo->getUserSessions($idUser);

      return view('sessions', ['sessions'=> $sessions, 'idUser' => $idUser]);
  }

    public function session($idSession){
      //Decifra o idSession
   //   $hashids = new \Hashids\Hashids(env('APP_KEY'),8);
   //   $idSession = $hashids->decode($idSession)[0];

        $session = $this->sessionsRepo->findByID($idSession);
        $user = $this->usersRepo->findByID($session->idUser);
        $exercises = $this->exercisesRepo->getSessionExercises($idSession);

        return view('session', ['session' => $session, 'user' => $user, 'exercises' => $exercises]);
    }

    public function progress($idSession){
      //Decifra o idSession
   //   $hashids = new \Hashids\Hashids(env('APP_KEY'),8);
   //   $idSession = $hashids->decode($idSession)[0];

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
      //   $hashids = new \Hashids\Hashids(env('APP_KEY'),8);
      //   $idExercise = $hashids->decode($idExercise)[0];

         $exercise = $this->exercisesRepo->findByID($idExercise);
         return view("exercise_feedback", ['exercise' => $exercise]);
    }
}
