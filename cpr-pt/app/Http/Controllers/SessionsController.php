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

        return view('session', ['session' => $session, 'user' => $user, 'exercises' => $exercises]);
    }
}  