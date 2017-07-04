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

class NewSessionController extends Controller{

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


    public function startSession(Request $request)
    {
        $this->validate($request, array(
                'title' => 'required|min:5|max:20'
        ));

        $session = Session::create([
            'idUser' => Auth::user()->id,
            'title' => $request->input('title'),
        ]);

        $idSession = $session->id;

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

    private function clearSession($idSession){
      $exercises = Exercise::where('idSession','=',$idSession)->get();
      $count = 0;
      foreach ($exercises as $exercise) {
          if($exercise->time == 0){
             Exercise::destroy($exercise->id);
             $count++;
          }
      }

      if($count==$exercises->count()){
          Session::destroy($idSession);
      }
   }

   public function end_session_no_view($idSession){
         $this->clearSession($idSession);
         return $idSession;
   }

    public function endSession($idSession){
      $this->clearSession($idSession);
      return redirect('/history/'.$idSession.'/session');
    }

    public function lastSession(){
      $lastSession = Session::where('idUser','=',Auth::user()->id)->get()->last();
      $lastSession = $lastSession->id;

      $newExercise = Exercise::create([
          'idSession'=>$lastSession,
          'time'=>0,
          'recoil'=>0,
          'compressions'=>0,
          'hand_position'=>0,
      ]);

     return view('newSession', ['id' => $lastSession, 'curExercise'=> $newExercise->id]);
   }

}
