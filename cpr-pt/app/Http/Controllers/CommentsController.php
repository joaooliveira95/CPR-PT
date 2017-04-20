<?php

namespace App\Http\Controllers;

use Auth;
use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repositories\UsersRepository;
use App\Repositories\SessionsRepository;
use App\Repositories\ExercisesRepository;
use App\Repositories\CommentsRepository;

class CommentsController extends Controller{

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

    
    public function send(Request $request, $session_id, $user_id){

        $this->validate($request, array(
                'comment' => 'required|min:1|max:2000'
            ));

        $comment = new Comment();
        $comment->comment=$request->comment;
        $comment->idUser=$user_id;
        $comment->idSession=$session_id;

        $comment->save();

        return redirect("students/$session_id/session");
    }
}  