<?php
namespace App\Repositories;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use App\User;

class UsersRepository extends BaseRepository
{
  protected $modelClass = User::class;

  public function getUsersByRole($role, $take = 8, $paginate = true){

        $query = $this->newQuery();
        $query ->where('role_id', '=', $role);
        $query ->orderBy('name');

      return $this->doQuery($query, $take, $paginate);
  }

  public function filterStudents($filter, $take = 8, $paginate = true){
        $by = 'name';
        if(strpos($filter, '@')!== false){
          $by = 'email';
        }

        $query = $this->newQuery();
        $query ->where('role_id', '=', 2);
        $query ->where($by, 'LIKE', '%'.request('filter').'%');
        $query ->orderBy('name');

        return $this->doQuery($query, $take, $paginate);
  }
}