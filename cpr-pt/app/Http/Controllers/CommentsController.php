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
        $session = $this->sessionsRepo->findByID($session_id);
        $comment = new Comment();
        $comment->comment=$request->comment;
        $comment->idFrom=$user_id;
        $comment->idTo=$session->idUser;
        $comment->idSession=$session_id;
        $comment->mark=0;

        $comment->save();

       return redirect()->back();

    }

    public function mark($id, $sessionId){
        $comment = Comment::find($id);
        $comment->mark = 1;
        $comment->save();

        $sessionId = $comment->idSession;
        return redirect('/history/'.$sessionId.'/session');
    }

    public function comments($user_id){
        $comments = $this->commentsRepo->getCommentsOfUser($user_id);
        if(request()->has('from') && request()->has('to')){
           $comments = $this->commentsRepo->getCommentsOfUserDate($user_id, request('from'),request('to'));
        }
        
       return view("commentsBox", ['comments'=>$comments]);

    }

    public function newComments(){
            $id = Auth::id();
            $new_comments = $this->commentsRepo->getNewCommentsOfUser($id)->count();
            $data=array("new_comments"=>$new_comments);
        return json_encode($data);
    }
}  