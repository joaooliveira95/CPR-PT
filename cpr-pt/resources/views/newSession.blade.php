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
                       animation: false,
                       backgroundColor: null,
                    },

                    boost: {
                        useGPUTranslations: true
                    },

                   
                    title: {
                        text: 'Dados da Sessão de Treino'
                    },

                    xAxis:{
                        min: 0,
                        softMax: 0,
                        minRange: 20000,
                        type: 'datetime',

                       title: {
                            text: 'Tempo (ms)'
                        },
          
                    },

                    yAxis: {
                        min: 0,
                        minRange: 5000,
                        title: {
                            text: 'Sensor (Definir Unidades)'
                        },
                    },

                    tooltip: {
                      enabled: false,
                       /* headerFormat: '<b>{series.name}</b><br />',
                        pointFormat: 'x = {point.x}, y = {point.y}'*/
                    },

                    legend: {
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'middle'

                    },

                    series: [{
                        name: 'Sensor1',
                        data: [],
                         states: {
                              hover: {
                                  enabled: false
                              }
                          }
                    }, {
                        name: 'Sensor2',
                        data: [],
                         states: {
                            hover: {
                                enabled: false
                            }
                        }
                    },{
                        name: 'Picos1',
                        data: [],
                         states: {
                              hover: {
                                  enabled: false
                              }
                          }
                    }, {
                        name: 'Picos2',
                        data: [],
                         states: {
                            hover: {
                                enabled: false
                            }
                        }
                    }],

                      credits: {
                          enabled: false
                      },

                    scrollbar:{
                      enabled: false,
                    }
          };

          chart = new Highcharts.Chart("progressao_treino", options);
          chart.series[0].setData([]);
          chart.series[1].setData([]);
          chart.series[2].setData([]);
          chart.series[3].setData([]);
          setInterval(function(){
           var url = "/exercise_progress/"+idExercise;

              $.get(url,function(result){
        
                var dados= jQuery.parseJSON(result);
                var total=dados.length;

                var highestTime = chart.xAxis[0].getExtremes().dataMax;
                for(var i=0;i<total;i++){
                  var time = Number(dados[i].time);
                 
                 if(time>highestTime){
                    chart.series[0].addPoint( [time, Number(dados[i].ponto_sensor1)], false, false);
                    chart.series[1].addPoint( [time, Number(dados[i].ponto_sensor2)], false, false); 

                    chart.series[2].addPoint( [time, Number(dados[i].picos_sensor1)], false, false);
                    chart.series[3].addPoint( [time, Number(dados[i].picosSensor2)], false, false); 
                  }    
                }
               
                });
              chart.redraw();

            },250);

        });

            function exercise(curExercise){
                  $("#exercise_button").attr("disabled", true); 
            
                  var url = "/script/"+idExercise+"&1";
                  $.get(url,function(result){
                  });

                  setTimeout(function(){
                    var url_resultados = "/exercise_results/"+idExercise;
                    window.open(url_resultados);
                  },21000);

            }
    </script>
@endsection

@section('content')
<div class="container" style="width: 90vw;">

    <div class="row">
      
        <div class="col-md-12">
            <div class="panel panel-default">
              <div class="panel-heading">{{trans('messages.exercise')}} {{$curExercise->id}}</div>

                <div class="panel-body">

                      <div id="progressao_treino" style="height:50vh;">
                        
                      </div>

                       <table class="table">
                          <tr>
                              <th style='text-align: center;'>Frquência</th>
                              <th style='text-align: center;'>Mãos Corretas</th>
                              <th style='text-align: center;'>Recoil Completo</th>
                          </tr>
                          <tr>
                              <td id="frequencia" style='text-align: center;'>0</td>
                              <td id="maos" style='text-align: center;'>0</td>
                              <td id="recoil" style='text-align: center;'>0</td>
                          </tr>
                          <tr>
                              <td id="recomend_frequencia" style='text-align: center;  border: none;'>Recomendacao</td>
                              <td id="recomend_maos" style='text-align: center; border: none;'>Recomendacao</td>
                              <td id="recomend_recoil" style='text-align: center; border: none;'>Recomendacao</td>
                          </tr>
                        </table>
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