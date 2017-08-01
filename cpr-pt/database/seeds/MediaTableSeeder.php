<?php

use Illuminate\Database\Seeder;
use App\Media;
use App\MediaCategory;
use Illuminate\Support\Facades\DB;

class MediaTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run(){
         $Protocolo =   MediaCategory::where('name','Protocolo CPR')->first();
         $Artigos =  MediaCategory::where('name','Artigos Relevantes')->first();

         Media::firstOrCreate([
            'title' => 'Indicações da OMS',
            'idCategory' => $Protocolo->id,
            'url' => "/coisas",
            'type' => 'PDF',
         ]);

         Media::firstOrCreate([
            'title' => 'Artigo sobre CPR',
            'idCategory' => $Artigos->id,
            'url' => "/coisas2",
            'type' => 'PDF',
         ]);

   }
}
