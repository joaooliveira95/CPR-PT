<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MediaCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
        Schema::create('media_categories', function (Blueprint $table) {
          $table->increments('id');
          $table->string('name');
          $table->string('description');
          $table->timestamps();
      });
     }

     /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down() {
          Schema::drop('media_categories');
     }
}
