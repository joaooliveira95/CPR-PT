<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Media;
use App\MediaCategory;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MediaCategoriesTest extends TestCase
{
	use DatabaseMigrations;
	use DatabaseTransactions;

	private function assertCategory($id, $category){

      $found_category=MediaCategory::find($id);
      $this->assertDatabaseHas('media_categories', [
         'name' => $category->name,
         'description'=> $category->description,
     ]);

	$this->assertEquals($found_category->id, $category->id);
	$this->assertEquals($found_category->name, $category->name);
	$this->assertEquals($found_category->description, $category->description);
	}

	private function assertMedia($id, $media, $category){

      $found_media=Media::find($id);
      $this->assertDatabaseHas('media', [
         'title' => $media->title,
         'idCategory'=> $category->id,
         'url' => $media->url,
         'type' => $media->type,
     ]);

	$this->assertEquals($found_media->id, $media->id);
	$this->assertEquals($found_media->idCategory, $media->idCategory);
	$this->assertEquals($found_media->url, $media->url);
	$this->assertEquals($found_media->type, $media->type);
   }


    public function testExample()
    {

    	$category1 = MediaCategory::create([
	     'name' => 'categoria1',
         'description'=> 'Descrição banal da categoria',
     	]);

    	$media1 = Media::create([
	     'title' => 'titulo',
         'idCategory'=> $category1->id,
         'url' => '/doe.com',
         'type' => '(PDF)',
     	]);

    	$this->assertCategory(1, $category1);
        $this->assertMedia(1, $media1, $category1);
    }
}
