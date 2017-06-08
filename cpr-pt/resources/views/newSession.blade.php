@extends('layouts.app')

@section('highcharts')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/boost.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
      <script>
      var chart;
         var compress_title = "{{trans('messages.compressions')}}";
   $(document).ready(function() {
        chart = new Highcharts.chart('progressao_treino', {
                    chart: {
                       type: 'line',
                       panning: true,
                      panKey: 'shift',
                        zoomType: 'x',
                        backgroundColor:'transparent',
                    },


                    boost: {
                        useGPUTranslations: true
                    },

                   
                    title: {
                        text: 'Dados da Sessão de Treino'
                    },

                    subtitle: {
                        text: 'CPR PT'
                    },

                    xAxis:{
                        min: 0,
                        minRange: 30000,
                        type: 'datetime',

                       title: {
                            text: 'Tempo (ms)'
                        },
          
                    },

                    yAxis: {
                        min: 0,
                        maxSoft: 10000,
                        minRange: 5000,
                        title: {
                            text: 'Sensor (Definir Unidades)'
                        },
                    },

                    tooltip: {
                        headerFormat: '<b>{series.name}</b><br />',
                        pointFormat: 'x = {point.x}, y = {point.y}'
                    },

                    legend: {
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'middle'
                    },

               
        
                    series: [{
                        name: 'Sensor1',
                        data: []
                    }, {
                        name: 'Sensor2',
                        data: []
                    }],

                    scrollbar:{
                      enabled: true,
                    }
          });
    });

            function setIntervalLimited(callback, interval, x) {
                flag = 0;
                for (var i = 0; i < x; i++) {
                    setTimeout(callback, i * interval); 
                }
            }

            function exercise(curExercise){
                    $("#exercise_button").attr("disabled", true); 
              
                    var startTime = new Date().getTime();
      
                    setInterval(function(){
                      var curTime = new Date().getTime();
                      var time = curTime-startTime;
                      var url = "/script/"+time+"/"+curExercise+"/"+1;
                        $.get(url, function(response){
                           });
                     },250); //10s


                      var url = "/exercise_progress/"+curExercise;
              
                      var compress = 0;
                      var hands = 0;
                      var time = 0;

                      setInterval(function(){
                      $.get(url,function(result){
                      
                        var dados= jQuery.parseJSON(result);
                        compress = Number(dados.ponto_sensor1);
                        hands = Number(dados.ponto_sensor2);
                        timestamp = Number(dados.time);

                        chart.series[0].addPoint([timestamp, compress]);
                        chart.series[1].addPoint([timestamp, hands]);
                     });
                    },250);

                    setTimeout(function(){
                        var url_resultados = "/exercise_results/"+curExercise;
                        window.open(url_resultados);
                    },25000);

            }
    </script>
@endsection

@section('content')
<div class="container">
    <div class="row">
                <div class="col-md-12 col-md-offset-0">
            <div class="panel panel-default">
                <div class="panel-heading">{{trans('messages.exercise')}} {{$curExercise->id}}</div>

                    <div class="panel-body">

                      <div id="info">
                         
                      </div>
                      <div id="progressao_treino">
                        
                      </div>

                       <div class = "inputs">
                          <li style="display: inline-block">   
                            <input class = "btn btn-default btn-sm" type="submit" name="filter_button" id="exercise_button" value="Start Exercise" onclick = "exercise({{$curExercise->id}})"/>
                          </li>

                          <li style="display: inline-block">
                             {!! Form::open(
                             array('action'=> array('NewSessionController@newExercise', $id)
                             , 'method'=>'post')) !!}

                             {!! Form::submit('Novo Treino', ['class'=>'btn btn-default btn-sm']) !!}

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
