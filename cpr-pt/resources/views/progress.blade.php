@extends('layouts.app')

@section('highcharts')
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script type="text/javascript" src="{{ URL::to('/js/highcharts.js') }}"></script>
<script type="text/javascript" src="{{ URL::to('/js/highcharts_options.js') }}"></script>

      <script>
            var chart;
            var idUser = {{$user->id}};
            var title = "{{trans('messages.progress')}}";
            var xTitle = "{{trans('messages.exercises')}}";
            var yTitle = "{{trans('messages.sensor_units')}}";

            $(document).ready(function() {
               var options = progresssChart();
                var url = "/exercises/"+idUser;
              $.get(url,function(result){
                  var dados = jQuery.parseJSON(result);
                  var chart_name = ["compressoes", "recoil", "pos_maos"];
                  var series_data = [dados.compress.reverse(), dados.recoil.reverse(), dados.hands.reverse()];
                  var series_name = ["{{trans('messages.compressions')}} (BPM)", "Recoil (%)",  "{{trans('messages.hands_position')}} (%)"];
                  var series_color =["#3a54dd","#FF0000","#a10dd5"]
                  var plot_interval =[[100, 120], [90, 100], [90, 100]];
                  var label_text = ["{{trans('messages.frequence')}} (100-120) BPM", "{{trans('messages.full_recoil')}} (90-100) %", "{{trans('messages.correct_hands')}} (90-100) %"];

                  for(var i = 0; i < 3; i++){
                     options.series[0].data = series_data[i];    //DADOS DOS EXERCICIOS
                     options.series[0].name = series_name[i];    //LEGENDA
                     options.series[0].color = series_color[i]; //COR DO GRAFICO
                     options.xAxis.categories = dados.dates.reverse();
                     if(i>0){
                        options.yAxis.max = 100;
                        options.yAxis.softMax= 100;
                     }else if(i==0){
                        options.yAxis.softMax= 120;
                     }
                     chart = new Highcharts.Chart(chart_name[i], options);

                     chart.yAxis[0].addPlotBand({
                          from: plot_interval[i][0],
                          to:  plot_interval[i][1],
                          color: 'rgba(5, 254, 0, 0.27)',
                          label: {
                             text: label_text[i],
                          }
                    });
                  }

              });
            });
    </script>
@endsection

@section('content')
<div class="container" style="margin-top: 70px; width:90vw;">
    <div class="row">
        <div class="col-md-12 ">
            <div class="panel panel-default shadow">
               <div class="panel-heading" style="height: 65px;">
                  <div class="row">
                     <ol class="breadcrumb breadcrumbs">
                       <li><a href="/home">Home</a></li>
                       <li class="active">Progress</li>
                     </ol>
                     <ul class="list-inline session_list">
                      <li class="nome_session">{{$user->name}}</li>
                      <li class="titulo_session"><b>{{trans('messages.progress')}}</b></li>
                   </ul>
                  </div>
             </div>

                <div class="panel-body">
                   <h4>Progresso dos exercícios efetuados pelo utilizador dividido pelos diferentes sensores.</h4>
                      <div class="row">
                           <div id="compressoes" class="col-md-4" style="height:50vh;">
                           </div>
                           <div id="recoil" class="col-md-4" style="height:50vh;">
                           </div>
                           <div id="pos_maos" class="col-md-4" style="height:50vh;">
                           </div>
                     </div>
                     <div class="row" style="margin: 30px 0 20px 0; padding: 0 0 0 25px;">
                        <div class="col-md-12" style="text-align: center;">
                           <a href="/sessions/{{$user->id}}" class="btn-sessoes">{{trans('messages.all_sessions')}}</a>
                        </div>
                     </div>
                  </div>
            </div>
        </div>
    </div>
</div>
@endsection
