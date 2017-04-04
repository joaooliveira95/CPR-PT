<?php
namespace App\Repositories;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use App\Session;

class SessionsRepository extends BaseRepository
{
  protected $modelClass = Session::class;

  public function getUserSessions($idUser,  $take = 8, $paginate = true){
        $query = $this->newQuery();
        $query ->where('idUser', '=', $idUser);
        $query ->orderBy('created_at', 'desc');

      return $this->doQuery($query, $take, $paginate);
  }

  public function getUserSessionsByDate($idUser, $from, $to,  $take = 8, $paginate = true){
        $query = $this->newQuery();
        $query ->where('idUser', '=', $idUser);
        $query->where('created_at', '>', $from);
        $query->where('created_at', '<', $to);
        $query ->orderBy('created_at', 'desc');

      return $this->doQuerySpecial($query, $take, $paginate, $from, $to);
  }
}