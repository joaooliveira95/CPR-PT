@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: 70px;">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default shadow">
                <div class="panel-heading">{{trans('messages.new_session')}}</div>

                    <div class="panel-body">

                      <img src="/cpr.jpg" class="img-responsive img-thumbnail center-block" style="margin-bottom: 5px; max-width: 80%">


                       {!! Form::open(
                       array('action'=> 'NewSessionController@startSession'
                       , 'method'=>'post')) !!}
                        {!! csrf_field() !!}
                       <h4 class="text-center">{!! Form::label('Title','Título') !!}</h4>
                      <div class="row">
                      <div class="input-group col-md-6 col-md-offset-3">
                        {!! Form::text('title', null, ['class'=>'form-control']) !!}
                        <span id="nova_sesao" class="input-group-btn">
                          {!! Form::submit('&#xf067;', ['class'=>'fa-input btn btn-default btn-md']) !!}
                        </span>
                      </div>
                            @if ($errors->has('title'))
                                <span class="help-block">
                                    <p class="text-warning"><strong>{{ $errors->first('title') }}</strong></p>
                                </span>
                            @endif
                      </div>
                      <a href="/lastSession">Ultima Sessao</a>
                      {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
