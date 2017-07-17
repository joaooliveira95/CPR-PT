<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMedia extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('media', function (Blueprint $table) {
         $table->increments('id');
         $table->string('title')->unique();
         $table->integer('idCategory')->unsigned();
         $table->foreign('idCategory')->references('id')->on('media_categories');
         $table->string('url');
         $table->string('type');
         $table->timestamps();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::dropIfExists('media');
    }
}
