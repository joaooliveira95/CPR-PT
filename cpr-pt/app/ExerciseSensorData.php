<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExerciseSensorData extends Model
{
     protected $fillable = [
        'idExercise', 'idSensor1', 'idSensor2', 'idSensor3', 'valueSensor1', 'valueSensor2', 'valueSensor3', 'timestep'
    ];

}
