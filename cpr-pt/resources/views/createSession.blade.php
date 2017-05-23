@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{trans('messages.new_session')}}</div>

                    <div class="panel-body">

                       {!! Form::open(
                       array('action'=> 'NewSessionController@startSession'
                       , 'method'=>'post')) !!}

                       {!! Form::label('Title','Título: ') !!}

                       {!! Form::text('title', null, ['class'=>'form-control']) !!}

                            @if ($errors->has('title'))
                                <span class="help-block">
                                    <p class="text-warning"><strong>{{ $errors->first('title') }}</strong></p>
                                </span>
                            @endif


                       {!! Form::submit('New', ['class'=>'btn btn-default btn-block', 'style'=>'margin-top:15px;']) !!}

                      {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
