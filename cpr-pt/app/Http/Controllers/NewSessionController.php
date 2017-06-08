<?php

namespace App\Http\Controllers;

use Auth;
use App\Session;
use App\Exercise;
use Illuminate\Http\Request;
use App\Repositories\SessionsRepository;
use App\Repositories\ExercisesRepository;
use App\Repositories\ExerciseSensorDatasRepository;

class NewSessionController extends Controller
{
    
    protected $sessionsRepo;
    protected $exercisesRepo;
    protected $dataRepo;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(SessionsRepository $sessionsRepo, ExercisesRepository $exercisesRepo, ExerciseSensorDatasRepository $dataRepo){
        $this->sessionsRepo = $sessionsRepo;
        $this->exercisesRepo = $exercisesRepo;
        $this->dataRepo = $dataRepo;
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

    public function newExercise($sessionId, $curExerciseId){

        $total_time = $this->dataRepo->getExerciseTime($curExerciseId);
 
        Exercise::where('id', $curExerciseId)
          ->update(['time' => $total_time[0]->timestep]);


        $newExercise = Exercise::create([
            'idSession'=>$sessionId,
            'time'=>0,
            'recoil'=>0,
            'compressions'=>0,
            'hand_position'=>0,
        ]);

        $exercises = $this->exercisesRepo->getSessionExercises($sessionId);
        return view('newSession', ['id' => $sessionId, 'curExercise'=> $newExercise]);
    }

  
}