@extends('layouts.app')

@section('highcharts')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
      <script>
            function progress(idSession) {

               var options = {

                    title: {
                        text: 'Session Progress'
                    },

                    subtitle: {
                        text: 'CPR PT'
                    },

                    xAxis:{
                       allowDecimals: false,
                      title: {
                            text: 'Exercises'
                        }
                    },

                    yAxis: {

                        title: {
                            text: 'Sensor Units'
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
                        name: 'Time',
                        data: []
                    },{
                        name: 'Recoil',
                        data: []
                    }, {
                        name: 'Compressions (BPM)',
                        data: []
                    }, {
                        name: 'Hand Position',
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

            }
    </script>
@endsection

@section('content')
<link href="{{ asset('/css/comentsStyle.css') }}" rel="stylesheet">
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
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
                                          <th>Exercise</th>
                                          <th>Time</th>
                                          <th>Recoil</th>
                                          <th>Compressions</th>
                                          <th>Hand Position</th>
                                      </tr>
                                  </thead>

                                  <tbody>
                                      @foreach($exercises as $exercise)
                                          <tr>
                                            <td>{{$exercise->id}}</td>
                                            <td>{{$exercise->time}}</td>
                                            <td>{{$exercise->recoil}}</td>
                                            <td>{{$exercise->compressions}}</td>
                                            <td>{{$exercise->hand_position}}</td>
                                          </tr>
                                      @endforeach
                                  </tbody>
                          </table>

                          {{ $exercises->links() }}
                      </div>
                      <h1 href="#" onclick = "progress({{$session->id}})"> Grafico </h1>
                          <div id="progresso_sessao">
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

				                        @if ($errors->has('comment'))
                                    <span class="help-block">
                                        <p class="text-warning"><strong>{{ $errors->first('comment') }}</strong></p>
                                    </span>
                                @endif


                      {!! Form::submit('Send', ['class'=>'btn btn-default btn-block', 'style'=>'margin-top:15px;']) !!}

                      {!! Form::close() !!}
                        @endif

            </div>
        </div>
    </div>
</div>

@endsection

