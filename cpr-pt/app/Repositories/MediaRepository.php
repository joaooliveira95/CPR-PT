<?php
namespace App\Repositories;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use App\MediaCategory;
use App\Media;

class MediaRepository extends BaseRepository
{
  protected $modelClass = Media::class;

  public function getAllMedia($take = 6, $paginate = true){
        $query = $this->newQuery();
        $query ->join('media_categories', 'media_categories.id', '=', 'media.idCategory');
        $query ->select('media.*', 'media_categories.name');
        $query ->orderBy('media_categories.name', 'media.title', 'asc');

      return $this->doQuery($query, $take, $paginate);
  }

  public function getMediaByCategory($idCategory, $take = 6, $paginate = true){
        $query = $this->newQuery();
        $query ->join('media_categories', 'media_categories.id', '=', 'media.idCategory');
        $query ->select('media.*', 'media_categories.name');
        $query ->where('media_categories.id','=', $idCategory);

      return $this->doQuery($query, $take, $paginate);
  }


}
