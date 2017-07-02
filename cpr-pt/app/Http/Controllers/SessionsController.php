<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repositories\UsersRepository;
use App\Repositories\SessionsRepository;
use App\Repositories\ExercisesRepository;

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

    private function date_conversion($date){
        $date = str_replace('/', '-', $date);
        $temp = explode(" ", $date);
        $date = $temp[0];
        $temp = explode("-", $date);
        $date = $temp[1]."-".$temp[0]."-".$temp[2];
        return $date;
   }

    public function sessions($id){

        if(request()->has('from') && request()->has('to')){

           $from = $this->date_conversion(request('from'));
           $to = $this->date_conversion(request('to'));

            $sessions = $this->sessionsRepo->getUserSessionsByDate($id, date("Y-m-d H:i:s", strtotime($from)), date("Y-m-d H:i:s", strtotime($to)));
            return view('sessions', ['sessions'=> $sessions, 'id' => $id]);
        }

        $sessions = $this->sessionsRepo->getUserSessions($id);

        return view('sessions', ['sessions'=> $sessions, 'id' => $id]);
    }

    public function session($id){

        $session = $this->sessionsRepo->findByID($id);
        $user = $this->usersRepo->findByID($session->idUser);
        $exercises = $this->exercisesRepo->getSessionExercises($id);

        return view('session', ['session' => $session, 'user' => $user, 'exercises' => $exercises]);
    }


    public function progress($id){
        $exercises = $this->exercisesRepo->getSessionExercises($id);
        $recoil = array();
        $compress =array();
        $hands = array();

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
        $recoil = array();
        $compress =array();
        $hands = array();
        $dates = array();
        $time = array();

        $cnt = count($exercises);

        for($i=0;$i<$cnt;$i++){
            $time[$i] = $exercises[$i]->time;
            $recoil[$i] = $exercises[$i]->recoil;
            $compress[$i]= $exercises[$i]->compressions;
            $dates[$i]= (string) $exercises[$i]->created_at->format('d/m/y h:i');
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
