<?php

use Illuminate\Database\Seeder;
use App\MediaCategory;
use Illuminate\Support\Facades\DB;

class MediaCategoriesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run(){
      if (MediaCategory::count() == 0) {

          MediaCategory::create([
             'name'           => 'Protocolo CPR',
             'description'    => 'Conteúdos sobre o protocolo CPR',
          ]);

         MediaCategory::create([
             'name'           => 'Artigos Relevantes',
             'description'          => 'Artigos relevantes sobre a prática de manobras de reanimação.',
          ]);
      }
   }
}
