@extends('layouts.app')

@section('highcharts')
<script type="text/javascript" src="{{ URL::to('/js/highcharts.js') }}"></script>
<script type="text/javascript" src="{{ URL::to('/js/boost.js') }}"></script>
<script type="text/javascript" src="{{ URL::to('/js/simulation_info.js') }}"></script>
      <script>
      //VARIAVEIS GLOBAIS
      var chart;
      var compress_title = "{{trans('messages.compressions')}}";
      var idExercise = "{{$curExercise}}";
      var idSession = "{{$id}}";
       var url_clear = "/endSession_nov/"+idSession;

      window.onunload=pageleave;
        function pageleave() {
            $.get(url_clear,function(result){});
        }

     $(document).ready(function() {
            $("#next_button").attr("disabled", true);
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
                        text: ''
                    },
                    xAxis:{
                        min: 0,
                        softmin: 0,
                        minRange: 20000,
                        type: 'datetime',

                       title: {
                            text: 'Tempo'
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
                    },

                    legend: {
                        align: 'right',
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
                      // chart.series[2].addPoint( [time, Number(dados[i].picos_sensor1)], false, false);
                      //chart.series[3].addPoint( [time, Number(dados[i].picosSensor2)], false, false);

                     simulation_live_info(dados[i].maos_corretas, dados[i].recoil, dados[i].frequencia);
                  }
             }
            });

            chart.redraw();
         },100);

      });

      function exercise(){
            $("#exercise_button").attr("disabled", true);
            $("#next_button").attr("disabled", false);
            var url = "/script/"+idExercise+"&1";
            $.get(url,function(result){
            });

      }


    </script>
@endsection

@section('content')
<div class="container" style="margin-top: 70px; width: 90vw;">

    <div class="row">

        <div class="col-md-12">
            <div class="panel panel-default shadow">
                <div class="panel-body">
                     <!-- <div class="title"><h2 class="text-center" style="font-family: 'Lato', Arial;">Dados da sessão</h2></div>-->


                      <div class="row">
                        <div class="col-md-4" style="min-width: 32%; float: left;">
                           <div class="panel panel-primary" style="border-color: #f1f1f1;">
                              <div class="panel-heading" style="background: #f1f1f1;color: #000;border-color: #f1f1f1;">
                                <b><p class="text-center" style='font-size: 15px;' >Frequência</p></b>
                              </div>
                               <b><p id="frequencia"></p></b>
                               <p id="recomend_frequencia"></p>
                           </div>
                        </div>
                        <div class="col-md-4" style="min-width: 32%; float: left;">
                           <div class="panel panel-primary" style="border-color: #f1f1f1;">
                              <div class="panel-heading" style="background: #f1f1f1;color: #000;border-color: #f1f1f1;">
                                <b><p class="text-center" style='font-size: 15px;' >Mãos Corretas</p></b>
                              </div>
                               <b><p id="pos_maos"></p></b>
                               <p id="recomend_pos_maos"></p>
                           </div>
                        </div>
                        <div class="col-md-4" style="min-width: 32%; float: left;">
                           <div class="panel panel-primary" style="border-color: #f1f1f1;">
                              <div class="panel-heading" style="background: #f1f1f1;color: #000;border-color: #f1f1f1;">
                                <b><p class="text-center" style='font-size: 15px;' >Recoil Completo</p></b>
                              </div>
                               <b><p id="recoil"></p></b>
                               <p id="recomend_recoil"></p>
                           </div>
                        </div>
                      </div>
                      <div id="progressao_treino" style="height:48vh;">

                      </div>
                       <div class = "inputs" style="margin: 0 auto; text-align: center;">
                          <li style="display: inline-block">
                            <input class = "btn btn-default btn-md fa-input" type="submit" name="filter_button" id="exercise_button" onclick = "exercise()" value="&#xf144;" style="color: green;"/>
                          </li>

                          <li style="display: inline-block">
                             {!! Form::open(
                             array('action'=> array('NewSessionController@newExercise', $id)
                             , 'mepod'=>'post')) !!}
                             {!! csrf_field() !!}
                             {!! Form::submit('&#xf28b;', ['id'=>'next_button', 'class'=>'fa-input btn btn-default btn-md', 'style'=>'margin: 0 10px 0 10px;']) !!}

                            {!! Form::close() !!}
                          </li>

                          <li style="display: inline-block">
                             {!! Form::open(
                             array('action'=> array('NewSessionController@endSession', $id)
                             , 'mepod'=>'post')) !!}
                             {!! csrf_field() !!}
                             {!! Form::submit('&#xf28d;', ['class'=>'fa-input btn btn-default btn-md', 'style'=>'color: red;']) !!}

                            {!! Form::close() !!}
                          </li>
                        </div>
                        @if (session('erro'))
                        <p class="text-warning"><strong>{{ session('erro')}}</strong></p>
                        @endif
                  </div>
              </div>
          </div>
      </div>
</div>
@endsection
