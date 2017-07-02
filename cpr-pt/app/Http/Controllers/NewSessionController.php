<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Support\Facades\DB;
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

        $hashids = new \Hashids\Hashids(env('APP_KEY'),8);
        $idSession = $hashids->decode($session->id)[0];

        $curExercise = Exercise::create([
            'idSession'=>$idSession,
            'time'=>0,
            'recoil'=>0,
            'compressions'=>0,
            'hand_position'=>0,
        ]);

        return view('newSession', ['id' => $idSession, 'curExercise'=> $curExercise->id]);
    }

    public function newExercise($idSession){
        $newExercise = Exercise::create([
            'idSession'=>$idSession,
            'time'=>0,
            'recoil'=>0,
            'compressions'=>0,
            'hand_position'=>0,
        ]);


        return view('newSession', ['id' => $idSession, 'curExercise'=> $newExercise->id]);
    }

    public function endSession(){

        return redirect('/history/sessions');
    }

    public function lastSession(){
      $lastSession = Session::all()->last();

      $hashids = new \Hashids\Hashids(env('APP_KEY'),8);

      $newExercise = Exercise::create([
          'idSession'=>$hashids->decode($lastSession->id)[0],
          'time'=>0,
          'recoil'=>0,
          'compressions'=>0,
          'hand_position'=>0,
      ]);


     return view('newSession', ['id' => $lastSession->id, 'curExercise'=> $newExercise->id]);
   }


}
