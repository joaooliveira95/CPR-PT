<?php
namespace App\Repositories;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use App\Session;

class SessionsRepository extends BaseRepository
{
  protected $modelClass = Session::class;

  public function getUserSessions($idUser,  $take = 6, $paginate = true){
        $query = $this->newQuery();
        $query ->join('users', 'users.id', '=', 'sessions.idUser');
        $query ->select('sessions.*', 'users.name');
        $query ->where('idUser', '=', $idUser);
        $query ->orderBy('created_at', 'desc');

      return $this->doQuery($query, $take, $paginate);
  }

  public function getUserSessionsByDate($idUser, $from, $to,  $take = 6, $paginate = true){
        $query = $this->newQuery();
        $query ->join('users', 'users.id', '=', 'sessions.idUser');
        $query ->select('sessions.*', 'users.name');
        $query ->where('idUser', '=', $idUser);
        $query->where('created_at', '>', $from);
        $query->where('created_at', '<', $to);
        $query ->orderBy('created_at', 'desc');

      return $this->doQuerySpecial($query, $take, $paginate, $from, $to);
  }
}