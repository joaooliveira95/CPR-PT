@extends('layouts.app')

@section('highcharts')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
      <script>
            function progress(idSession) {
             
               var options = {

                    title: {
                        text: 'Progresso da Sessão'
                    },

                    subtitle: {
                        text: 'CPR PT'
                    },

                    xAxis:{
                       allowDecimals: false,
                      title: {
                            text: 'Treinos'
                        }
                    },

                    yAxis: {

                        title: {
                            text: 'Unidades do sensor'
                        }
                    },
                    legend: {
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'middle'
                    },

                    plotOptions: {
                      
                        series: {
                            pointStart: 0
                        }
                    },

        
                    series: [{
                        name: 'Tempo (s)',
                        data: []
                    },{
                        name: 'Recoil',
                        data: []
                    }, {
                        name: 'Compressões',
                        data: []
                    }, {
                        name: 'Pos. Mãos (%)',
                        data: []
                    }]
                    
                };

                var url = "/progress/"+idSession;
              $.get(url,function(result){
              
                var dados= jQuery.parseJSON(result);
                var total=dados.recoil.length;
                var i=0;
                for(i=0;i<total;i++){
                  options.series[0].data.push( dados.time[i] );
                  options.series[1].data.push( dados.recoil[i] );
                  options.series[2].data.push( dados.compress[i] );
                  options.series[3].data.push( dados.hands[i] );      
                }
                //options.title.text="aqui e podria cambiar el titulo dinamicamente";
                chart = new Highcharts.Chart("progresso_sessao", options);
              })

                var x = document.getElementById('progresso_sessao');
                if(x.style.display == "block"){
                  x.style.display = "none";
                }else{
                  x.style.display = "block";
                }
            }
    </script>
@endsection

@section('content')
<link href="{{ asset('/css/comentsStyle.css') }}" rel="stylesheet">
<div class="container">
    <div class="row">
       <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">{{$user->name}} | {{$session->title}} | {{$session->created_at}}</div>

                <div class="panel-body">

                  <div id="treinos">
                          @if($exercises!=null)
                            <div class="table-responsive">
                             <table id="sessions_table" class='table table-hover'>
                                   <br>
                                  <thead class="thead-default">
                                      <tr>
                                          <th class = "centered_tb">{{trans('messages.exercise')}}</th>
                                          <th class = "centered_tb">{{trans('messages.time')}}</th>
                                          <th class = "centered_tb">Recoil</th>
                                          <th class = "centered_tb">{{trans('messages.compressions')}}</th>
                                          <th class = "centered_tb">{{trans('messages.hands_position')}}</th>
                                      </tr>
                                  </thead>

                                  <tbody>
                                      @foreach($exercises as $exercise)
                                          <tr>
                                            <td class = "centered_tb"><a href="/exercise_results/{{$exercise->id}}"> {{$exercise->id}} </a></td>
                                            <td class = "centered_tb">{{$exercise->time}}</td>
                                            <td class = "centered_tb">{{$exercise->recoil}}</td>
                                            <td class = "centered_tb">{{$exercise->compressions}}</td>
                                            <td class = "centered_tb">{{$exercise->hand_position}}</td>
                                          </tr>
                                      @endforeach
                                  </tbody>
                          </table>

                          
                      </div>
                        {{$exercises->links()}}
                  </div>
                    

                  <h3 onclick="progress({{$session->id}})"> Gráfico </h1>
                  <div id="progresso_sessao">
                          </div>
                    @endif

                  @if($comments!=null)
                    <hr>
                      <div class="row">
                        <div class="col-md-12">
                        <h3 class="comments-title"> {{ $comments->count()}} {{trans('messages.comments')}}</h3>
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

                     {!! Form::open(
                       array('action'=> array('CommentsController@send', $session->id, Auth::user()->id)
                       , 'method'=>'post')) !!}


                    <!--{!! Form::label('comment','Comment: ') !!}-->
                   
                      {!! Form::textArea('comment', null, ['class'=>'form-control', 'rows'=>'5' ]) !!}

	                        @if ($errors->has('comment'))
                              <span class="help-block">
                                  <p class="text-warning"><strong>{{ $errors->first('comment') }}</strong></p>
                              </span>
                          @endif

                      {!! Form::submit('Send', ['class'=>'btn btn-default btn-block', 'style'=>'margin-top:15px;']) !!}

                      {!! Form::close() !!}

            </div>
            {{$comments->links()}}
        </div>
    </div>
</div>

@endsection

