@extends('layouts.app')

@section('highcharts')

<script type="text/javascript" src="{{ URL::to('/js/highstock.js') }}"></script>
<script type="text/javascript" src="{{ URL::to('/js/boost.js') }}"></script>
<script type="text/javascript" src="{{ URL::to('/js/simulation_info.js') }}"></script>

      <script>
      var chart;
      var idExercise = "{{$exercise->id}}";
   $(document).ready(function() {

               var options = {

                    chart: {
                       type: 'line',
                       panning: true,
                      panKey: 'shift',
                        zoomType: 'x',
                        backgroundColor:'transparent',
                    },

                    plotOptions: {
                        series: {
                            animation: false
                        }
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
                        minRange: 10000,
                        type: 'datetime',

                       title: {
                            text: 'Tempo'
                        },

                    },

                    yAxis: {
                        min: 0,
                        title: {
                            text: 'Sensor (Definir Unidades)'
                        },

                    },

                    tooltip: {
                        headerFormat: '<b>{series.name}</b><br />',
                        pointFormat: 'x = {point.x}, y = {point.y}'
                    },

                    legend: {

                        align: 'right',

                    },

                      credits: {
                          enabled: false
                      },


                    series: [{
                        name: 'Compressões',
                        data: []
                    }, {
                        name: 'Pos_Mãos',
                        data: []
                    },{
                        name: 'Picos1',
                        data: []
                    }, {
                        name: 'Picos2',
                        data: []
                    }],

                    scrollbar:{
                      enabled: true,
                    }


                };


                var url = "/exercise_progress/"+idExercise;
              $.get(url,function(result){

                var dados= jQuery.parseJSON(result);
                var total=dados.length;

                var i;
                var time = 0;
                for(i=0;i<total;i++){
                  time = Number(dados[i].time);

                  options.series[0].data.push( [time, Number(dados[i].ponto_sensor1)]);
                  options.series[1].data.push( [time, Number(dados[i].ponto_sensor2)]);

                  options.series[2].data.push( [time, Number(dados[i].picos_sensor1)]);
                  options.series[3].data.push( [time, Number(dados[i].picosSensor2)]);


                }
               simulation_feedback(dados[total-1].maos_corretas, dados[total-1].rcc, dados[total-1].frequencia, time);

                chart = new Highcharts.Chart("treino", options);

                })
              });
    </script>
@endsection

@section('content')
<link href="{{ asset('/css/comentsStyle.css') }}" rel="stylesheet">
<div class="container" style="width: 90vw;">
    <div class="row">
       <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default shadow">
            <div class="panel-heading">{{trans('messages.exercise_feedback')}} {{$exercise->id}}</div>

            <div class="panel-body">
              <div id="tempo_treino" class="col-md-4">
                 <h4><center><b>{{trans('messages.time')}}</b></center></h4>
                <div class="table-responsive">
                 <table id="table_1" class='table table-hover'>
                    <br>
                    <thead class="thead-default">
                      <tr>
                        <th class = "centered_tb">{{trans('messages.total_time')}}</th>
                        <th class = "centered_tb">COMPRESS. {{trans('messages.time')}}</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td id="tempo" class = "centered_tb"></td>
                        <td class = "centered_tb">{{$exercise->time}} s</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div id="resultados_treino" class="col-md-8">
                <h4><center><b>{{trans('messages.compressions')}}</b></center></h4>
                <div class="table-responsive">
                 <table id="table_2" class='table table-hover'>
                       <br>
                      <thead class="thead-default">
                          <tr>
                              <th class = "centered_tb">{{trans('messages.frequence')}}</th>
                              <th class = "centered_tb">{{trans('messages.full_recoil')}}</th>
                              <th class = "centered_tb">{{trans('messages.correct_hands')}}</th>
                          </tr>
                      </thead>

                      <tbody>
                        <tr>
                            <td id="frequencia" class = "centered_tb" style="color:green"></td>

                          <!--RECOIL-->
                            <td id="recoil" class = "centered_tb" style="color:red"></td>
                          <!--HANDS-->
                            <td id="pos_maos" class = "centered_tb"></td>
                        </tr>
                      </tbody>
                  </table>
                  </div>
              </div>

          </div>
          <div id="treino" style="height:60vh;>

              </div>
            </div>
        </div>
    </div>
</div>

@endsection
