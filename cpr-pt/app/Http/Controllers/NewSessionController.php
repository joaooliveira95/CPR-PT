<?php

namespace App\Http\Controllers;

use Auth;
use App\Session;
use App\Exercise;
use Illuminate\Http\Request;
use App\Repositories\SessionsRepository;
use App\Repositories\ExercisesRepository;



class NewSessionController extends Controller
{
    
    protected $sessionsRepo;
    protected $exercisesRepo;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(SessionsRepository $sessionsRepo, ExercisesRepository $exercisesRepo)
    {
        $this->sessionsRepo = $sessionsRepo;
        $this->exercisesRepo = $exercisesRepo;
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(){
        return view('createSession');
    }

    public function startSession(Request $request)
    {     
        $this->validate($request, array(
                'title' => 'required|min:5|max:20'
        ));

        $session = Session::create([
            'idUser' => Auth::user()->id,
            'title' => $request->input('title'),
        ]);

        $curExercise = Exercise::create([
            'idSession'=>$session->id,
            'time'=>0,
            'recoil'=>0,
            'compressions'=>0,
            'hand_position'=>0,
        ]);

        //$exercises = $this->exercisesRepo->getSessionExercises($sessionId);
        return view('newSession', ['id' => $session->id, 'curExercise'=> $curExercise]);
    }

    public function newExercise($sessionId){
        $curExercise = Exercise::create([
            'idSession'=>$sessionId,
            'time'=>0,
            'recoil'=>0,
            'compressions'=>0,
            'hand_position'=>0,
        ]);

        $exercises = $this->exercisesRepo->getSessionExercises($sessionId);
        return view('newSession', ['id' => $sessionId, 'curExercise'=> $curExercise]);
    }

  
}