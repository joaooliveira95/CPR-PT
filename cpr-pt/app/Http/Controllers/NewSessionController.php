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
    public function index()
    {   

        date_default_timezone_get();
        $date = date('Y-m-d h:i:s', time());

        $session = Session::create([
            'idUser' => Auth::user()->id,
            'time' => $date
        ]);
        return view('newSession', ['id' => $session->id, 'exercises'=>null]);
    }

    public function newExercise($sessionId){
        Exercise::create([
            'idSession'=>$sessionId,
            'duracaoTotal'=>10,
            'duracaoParcial'=>10,
            'nmaosCorretas'=>10,
            'nmaosIncorretas'=>10,
            'ncompressoesCorretas'=>10,
            'ncompressoesIncorretas'=>10,
            'nrecoilCorreto'=>10,
            'nrecoilIncorreto'=>10
        ]);


        $exercises = $this->exercisesRepo->getSessionExercises($sessionId);
        return view('newSession', ['id' => $sessionId, 'exercises'=> $exercises]);
    }

}