<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Support\Facades\DB;
use App\Session;
use App\Exercise;
use Illuminate\Http\Request;
use App\Repositories\SessionsRepository;
use App\Repositories\ExercisesRepository;

class NewSessionController extends Controller{

    protected $sessionsRepo;
    protected $exercisesRepo;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(SessionsRepository $sessionsRepo, ExercisesRepository $exercisesRepo){
        $this->sessionsRepo = $sessionsRepo;
        $this->exercisesRepo = $exercisesRepo;
        $this->middleware('auth');
    }

   private function createExercise($idSession){
      return Exercise::create([
          'idSession'=>$idSession,
          'time'=>0,
          'recoil'=>0,
          'compressions'=>0,
          'hand_position'=>0,
      ]);
   }

   //Elimina todos os exercicios da sessão que não tenham sido inicializados, sem dados, interrompidos de inicio
   private function clearSession($idSession){
      $exercises = Exercise::where('idSession','=',$idSession)->get();
      $count = 0;
      //Apaga os exercicioes em "branco" e vai contando
      foreach ($exercises as $exercise) {
          if($exercise->time == 0){
             Exercise::destroy($exercise->id);
             $count++;
          }
      }
      //Se o número de exercicios corresponde ao total de exercicios da sessão, elimina tb a sessao
      if($count==$exercises->count()){
          Session::destroy($idSession);
      }
   }


    public function startSession(Request $request){
        $this->validate($request, array(
                'title' => 'required|min:5|max:20'
        ));

        $session = Session::create([
            'idUser' => Auth::user()->id,
            'title' => $request->input('title'),
        ]);

        $idSession = $session->id;
        $curExercise = $this->createExercise($idSession);

        return view('newSession', ['id' => $idSession, 'curExercise'=> $curExercise->id]);
    }

    public function newExercise($idSession){
           $newExercise = $this->createExercise($idSession);
           return view('newSession', ['id' => $idSession, 'curExercise'=> $newExercise->id]);
    }


   //Evocado sempre q muda de pagina ou atualiza
   public function end_session_no_view($idSession){
         $this->clearSession($idSession);
         return $idSession;
   }

    public function endSession($idSession){
      $this->clearSession($idSession);
      return redirect('/history/'.$idSession.'/session');
    }

   //Procura a última sessão do utilizador
   //Continua a sessão, criando um novo exercicio q pertence a essa sessão
    public function lastSession(){
      $id_auth = Auth::user()->id;
            //Valida se o utilizador já tem alguma sessão para continuar
      if(Session::where('idUser','=', $id_auth)->count() > 0){
               //Query q obtem a ultima sessao realizada pelo utilizador atualmente autenticado
               $lastSession = Session::where('idUser','=', $id_auth)->get()->last();
               $lastSession = $lastSession->id;
               $newExercise = $this->createExercise($lastSession);

              return view('newSession', ['id' => $lastSession, 'curExercise'=> $newExercise->id]);
      }

       return redirect("/newSession")->with('erro', 'O utilizador não tem nenhuma sessão!');
   }

}
