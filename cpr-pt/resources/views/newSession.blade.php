@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">New Session</div>

                    <div class="panel-body">

                      <div id="info">
                         
                      </div>

                       <div style="display: inline">
                           <input class = "btn btn-default btn-sm" type="submit" name="filter_button" id="exercise_button" value="New Exercise" onclick = "exercise({{$curExercise->id}})"/>

                           <input class = "btn btn-default btn-sm" type="submit" name="filter_button" id="filter_button" value="End Session" onclick="location.href='/history';"/>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
