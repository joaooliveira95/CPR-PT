@extends('layouts.app')

@section('content')
<link href="{{ asset('/css/comentsStyle.css') }}" rel="stylesheet">
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{$user->name}} session : {{$session->created_at}}</div>

                <div class="panel-body">

                      <div id="treinos">
                          @if($exercises!=null)
                            <div class="table-responsive">
                             <table id="sessions_table" class='table table-hover'>
                                   <br>
                                  <thead class="thead-default">
                                      <tr>
                                          <th>idSession</th>
                                          <th>Total Duration</th>
                                          <th>Parcial Duration</th>
                                          <th>N Correct Compressions</th>
                                          <th>N Incorrect Compressions</th>
                                      </tr>
                                  </thead>

                                  <tbody>
                                      @foreach($exercises as $exercise)
                                          <tr>
                                            <td>{{$exercise->id}}</td>
                                            <td>{{$exercise->duracaoTotal}}</td>
                                            <td>{{$exercise->duracaoParcial}}</td>
                                            <td>{{$exercise->ncompressoesCorretas}}</td>
                                            <td>{{$exercise->ncompressoesIncorretas}}</td>
                                          </tr>
                                      @endforeach
                                  </tbody>
                          </table>

                          {{ $exercises->links() }}
                      </div>
                    @endif
                    


                    @if($comments!=null)
                    <hr>
                      <div class="row">
                        <div class="col-md-12">
                        <h3 class="comments-title"> {{ $comments->count()}} Comments</h3>
                          @foreach($comments as $comment)
                            <div class="comment">
                                <div class="author-info">
                                    <div class="author-name">
                                      <h4>{{$comment->name}}</h4>
                                    </div>
                                    <p class="author-time">{{$comment->created_at}}</p>
                                </div>
                                <div class="comment-content">
                                    {{$comment->comment}}
                                </div>
                            </div>
                          @endforeach
                        </div>
                      </div>
                    @endif



                        @if(Auth::user()->role_id==1 || Auth::user()->role_id==3)
                     {!! Form::open(
                       array('action'=> array('CommentsController@send', $session->id, Auth::user()->id)
                       , 'method'=>'post')) !!}


                       {!! Form::label('comment','Comment: ') !!}
                   
                      {!! Form::textArea('comment', null, ['class'=>'form-control', 'rows'=>'5' ]) !!}

                      {!! Form::submit('Send', ['class'=>'btn btn-default btn-block', 'style'=>'margin-top:15px;']) !!}

                      {!! Form::close() !!}
                        @endif

            </div>
        </div>
    </div>
</div>
@endsection
