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

                       <div class = "inputs">
                          <li style="display: inline-block">   
                            <input class = "btn btn-default btn-sm" type="submit" name="filter_button" id="exercise_button" value="Start Exercise" onclick = "exercise({{$curExercise->id}})"/>
                          </li>

                          <li style="display: inline-block">
                             {!! Form::open(
                             array('action'=> array('NewSessionController@newExercise', $id)
                             , 'method'=>'post')) !!}

                             {!! Form::submit('New Exercise', ['class'=>'btn btn-default btn-sm']) !!}

                            {!! Form::close() !!}
                          </li>

                          <li style="display: inline-block">
                            <input class = "btn btn-danger btn-sm" type="submit" name="filter_button" id="filter_button" value="End Session" onclick="location.href='/history';"/>
                          </li>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
