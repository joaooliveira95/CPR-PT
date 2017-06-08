@extends('layouts.app')

@section('highcharts')
<script type="text/javascript" src="{{ URL::to('/js/highcharts.js') }}"></script>
<script type="text/javascript" src="{{ URL::to('/js/boost.js') }}"></script>

      <script>
      var chart;
         var compress_title = "{{trans('messages.compressions')}}";
             var idExercise = "{{$curExercise->id}}";

    function setIntervalLimited(callback, interval, x) {
        flag = 0;
        for (var i = 0; i < x; i++) {
            setTimeout(callback, i * interval); 
        }
    }

     $(document).ready(function() {
           var options = {
                    chart: {
                       type: 'line',

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
          };
          chart = new Highcharts.Chart("progressao_treino", options);
          chart.series[0].setData([]);
          chart.series[1].setData([]);
           var url = "/exercise_feedback/"+idExercise;
           setInterval(function(){
              $.get(url,function(result){
        
                var dados= jQuery.parseJSON(result);
                var total=dados.length;

                var i;
                for(i=0;i<total;i++){
                  var time = Number(dados[i].time);
                  var highestTime = chart.xAxis[0].getExtremes().dataMax;
                  if(time>highestTime){
                    chart.series[0].addPoint( [time, Number(dados[i].ponto_sensor1)]);
                    chart.series[1].addPoint( [time, Number(dados[i].ponto_sensor2)]); 
                  }    
                }

               
                });
            },50);


              
        });

            function setIntervalLimited(callback, interval, x) {
                flag = 0;
                for (var i = 0; i < x; i++) {
                    setTimeout(callback, i * interval); 
                }
            }

            function exercise(curExercise){
                  $("#exercise_button").attr("disabled", true); 
            
                  var url = "/script/"+idExercise+"&1";
                  $.get(url,function(result){
                  });

                  setTimeout(function(){
                    var url_resultados = "/exercise_results/"+idExercise;
                    window.open(url_resultados);
                  },20000);

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
                             array('action'=> array('NewSessionController@newExercise', $id, $curExercise->id)
                             , 'method'=>'post')) !!}

                             {!! Form::submit('New Exercise', ['class'=>'btn btn-default btn-sm']) !!}

                            {!! Form::close() !!}
                          </li>

                          <li style="display: inline-block">
                             {!! Form::open(
                             array('action'=> array('NewSessionController@endSession', $curExercise->id)
                             , 'method'=>'post')) !!}

                             {!! Form::submit('End Session', ['class'=>'btn btn-danger btn-sm']) !!}

                            {!! Form::close() !!}
                          </li>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
