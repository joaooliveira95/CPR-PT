<?php
namespace App\Repositories;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use App\Session;

class SessionsRepository extends BaseRepository
{
  protected $modelClass = Session::class;

  public function getUserSessions($idUser,  $take = null, $paginate = false){
        $query = $this->newQuery();
        $query ->join('users', 'users.id', '=', 'sessions.idUser');
        $query ->select('sessions.*', 'users.name');
        $query ->where('idUser', '=', $idUser);
        $query ->orderBy('created_at', 'desc');

      return $this->doQuery($query, $take, $paginate);
  }
}
