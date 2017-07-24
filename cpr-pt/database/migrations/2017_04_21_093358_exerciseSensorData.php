<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ExerciseSensorData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exercise_sensors_data', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idExercise')->unsigned();
            $table->foreign('idExercise')->references('id')->on('exercises')->onDelete('cascade');
            $table->integer('idSensor1')->unsigned();
            $table->integer('idSensor2')->unsigned();
            $table->integer('idSensor3')->unsigned();
            $table->integer('valueSensor1');
            $table->integer('valueSensor2');
            $table->integer('valueSensor3');
            $table->integer('timestep');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('exercise_sensors_data');
    }
}
