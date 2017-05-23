<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repositories\UsersRepository;
use App\Repositories\SessionsRepository;
use App\Repositories\ExercisesRepository;
use App\Repositories\CommentsRepository;

class SessionsController extends Controller{

    protected $sessionsRepo;
    protected $exercisesRepo;
    protected $commentsRepo;
    protected $usersRepo;

    public function __construct(UsersRepository $usersRepo, SessionsRepository $sessionsRepo, ExercisesRepository $exercisesRepo, CommentsRepository $commentsRepo){
        $this->usersRepo = $usersRepo;
        $this->sessionsRepo = $sessionsRepo;
        $this->exercisesRepo = $exercisesRepo;
        $this->commentsRepo = $commentsRepo;
        $this->middleware('auth');
    }

    public function sessions($id){

        if(request()->has('from') && request()->has('to')){
            $sessions = $this->sessionsRepo->getUserSessionsByDate($id, request('from'), request('to'));
            return view('sessions', ['sessions'=> $sessions, 'id' => $id]);
        }

          $sessions = $this->sessionsRepo->getUserSessions($id);

        return view('sessions', ['sessions'=> $sessions, 'id' => $id]);
    }

    public function session($id){

        $session = $this->sessionsRepo->findByID($id);
        $user = $this->usersRepo->findByID($session->idUser);
        $exercises = $this->exercisesRepo->getSessionExercises($id);
        $comments = $this->commentsRepo->getCommentsBySession($id);

        return view('session', ['session' => $session, 'user' => $user, 'exercises' => $exercises, 'comments' => $comments]);
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
            $hands[$i]= rand(0,100);//$exercises[$i]->hand_position;
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

        $cnt = count($exercises);
        
        for($i=0;$i<$cnt;$i++){
            $time[$i] = $exercises[$i]->time;
            $recoil[$i] = $exercises[$i]->recoil;
            $compress[$i]= $exercises[$i]->compressions;
            $dates[$i]= (string) $exercises[$i]->created_at->format('d/m/y h:i');
            $hands[$i]= rand(0,100);//$exercises[$i]->hand_position;
        }

        $data=array("time"=>$time, "recoil"=>$recoil,"compress"=>$compress, "hands"=>$hands, "dates"=>$dates);
        return json_encode($data);
    }


}  