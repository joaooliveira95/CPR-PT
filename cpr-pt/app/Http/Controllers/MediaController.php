<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repositories\MediaRepository;
use App\MediaCategory;
use App\Media;

class MediaController extends Controller{

   protected $mediaRepo;

    public function __construct(MediaRepository $mediaRepo){
        $this->mediaRepo=$mediaRepo;
        $this->middleware('auth');
    }

    public function contentIndex(){

      return view("content");
    }

    public function contentInfo(){
      $categories = MediaCategory::all();
      $array = array();

      $array['categories']=$categories;
      foreach ($categories as $category) {
         $temp = Media::where('idCategory','=',$category->id)->get();
         $array[$category->name] = $temp;
      }
      return json_encode($array);
    }

}
