@extends('layouts.app')

@section('highcharts')

<script type="text/javascript" src="{{ URL::to('/js/highstock.js') }}"></script>
<script type="text/javascript" src="{{ URL::to('/js/boost.js') }}"></script>

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
                            text: 'Tempo (ms)'
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


                var url = "/exercise_feedback/"+idExercise;
              $.get(url,function(result){
        
                var dados= jQuery.parseJSON(result);
                var total=dados.length;

                var i;

                for(i=0;i<total;i++){
                  var time = Number(dados[i].time);

                  options.series[0].data.push( [time, Number(dados[i].ponto_sensor1)]);
                  options.series[1].data.push( [time, Number(dados[i].ponto_sensor2)]);     
                }
           
                chart = new Highcharts.Chart("treino", options);
              
                })
              });
    </script>
@endsection

@section('content')
<link href="{{ asset('/css/comentsStyle.css') }}" rel="stylesheet">
<div class="container">
    <div class="row">
       <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
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
                        <th class = "centered_tb">COMPRESSIONS {{trans('messages.time')}}</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td class = "centered_tb">{{$exercise->time}} s</td>
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
                          <!--FREQUENCE-->
                          @if($exercise->compressions > 100 && $exercise->compressions< 120)
                            <td class = "centered_tb" style="color:green">{{$exercise->compressions}} BPM</td>
                          @else
                            <td class = "centered_tb" style="color:red">{{$exercise->compressions}} BPM</td>
                          @endif

                          <!--RECOIL-->
                          @if($exercise->recoil<50)
                            <td class = "centered_tb" style="color:red">{{$exercise->recoil}} %</td>
                          @elseif($exercise->recoil>80)
                            <td class = "centered_tb" style="color:green">{{$exercise->recoil}} %</td>
                          @else
                            <td class = "centered_tb">{{$exercise->recoil}} %</td>
                          @endif
                         
                          <!--HANDS-->
                          @if($exercise->hand_position<50)
                            <td class = "centered_tb" style="color:red">{{$exercise->hand_position}} %</td>
                          @elseif($exercise->hand_position>80)
                            <td class = "centered_tb" style="color:green">{{$exercise->hand_position}} %</td>
                          @else
                            <td class = "centered_tb">{{$exercise->hand_position}} %</td>
                          @endif()
                        </tr>
                      </tbody>
                  </table>
                  </div>
              </div>
              
          </div>
          <div id="treino" style="height: 400px;">

              </div>
            </div>
        </div>
    </div>
</div>

@endsection

