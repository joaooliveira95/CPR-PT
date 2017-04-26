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
            $table->foreign('idExercise')->references('id')->on('exercises');
            $table->integer('idSensor1')->unsigned();
            $table->foreign('idSensor1')->references('id')->on('sensors');
            $table->integer('idSensor2')->unsigned();
            $table->foreign('idSensor2')->references('id')->on('sensors');
            $table->integer('idSensor3')->unsigned();
            $table->foreign('idSensor3')->references('id')->on('sensors');
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
        Schema::dropIfExists('exercise_sensors_data');
    }
}
