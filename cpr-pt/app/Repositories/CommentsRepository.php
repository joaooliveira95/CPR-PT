<?php
namespace App\Repositories;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use App\Comment;

class CommentsRepository extends BaseRepository
{
  protected $modelClass = Comment::class;

  public function getCommentsBySession($idSession, $take = 5, $paginate = true){

        $query = $this->newQuery();
        $query ->join('users', 'users.id', '=', 'comments.idFrom');
        $query ->select('comments.*', 'users.name');
        $query ->where('idSession', '=', $idSession);
        $query ->orderBy('created_at','desc');

      return $this->doQuery($query, $take, $paginate);
  }

    public function getCommentsOfUser($idUser, $take = 3, $paginate = true){

        $query = $this->newQuery();
        $query ->join('users', 'users.id', '=', 'comments.idFrom');
        $query ->join('sessions', 'sessions.id', '=', 'comments.idSession');
        $query ->select('comments.*', 'users.name', 'sessions.title');
        $query ->where('idTo', '=', $idUser);
        $query ->where('idFrom', '!=', $idUser);
        $query ->orderBy('created_at','desc');

      return $this->doQuery($query, $take, $paginate);
  }

  public function getCommentsOfUserDate($idUser, $from, $to, $take = 3, $paginate = true){

        $query = $this->newQuery();
        $query ->join('users', 'users.id', '=', 'comments.idFrom');
        $query ->join('sessions', 'sessions.id', '=', 'comments.idSession');
        $query ->select('comments.*', 'users.name', 'sessions.title');
        $query ->where('idTo', '=', $idUser);
        $query ->where('idFrom', '!=', $idUser);
        $query->where('comments.created_at', '>', $from);
        $query->where('comments.created_at', '<', $to);
        $query ->orderBy('created_at','desc');

      return $this->doQuerySpecial($query, $take, $paginate, $from, $to);
  }
}