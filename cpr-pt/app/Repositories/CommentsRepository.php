<?php
namespace App\Repositories;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use App\Comment;

class CommentsRepository extends BaseRepository
{
  protected $modelClass = Comment::class;

  public function getCommentsBySession($idSession, $take = 20, $paginate = false){

        $query = $this->newQuery();
        $query ->join('users', 'users.id', '=', 'comments.idUser');
        $query ->select('comments.*', 'users.name');
        $query ->where('idSession', '=', $idSession);
        $query ->orderBy('created_at','desc');

      return $this->doQuery($query, $take, $paginate);
  }
}