@extends('layouts.app')

@section('highcharts')
<script type="text/javascript" src="{{ URL::to('/js/highcharts.js') }}"></script>
<script type="text/javascript" src="{{ URL::to('/js/boost.js') }}"></script>
<script type="text/javascript" src="{{ URL::to('/js/simulation_info.js') }}"></script>
<script type="text/javascript" src="{{ URL::to('/js/highcharts_options.js') }}"></script>
      <script>
      //VARIAVEIS GLOBAIS
      var chart;
      var compress_title = "{{trans('messages.compressions')}}";
      var idExercise = "{{$curExercise}}";
      var idSession = "{{$id}}";
      var url_clear = "/endSession_nov/"+idSession;
      var snd = new Audio("{{ URL::to('/beep-1.flac') }}");
      var playing = false;

      window.onunload=pageleave;
     function pageleave() {
         $.get(url_clear,function(result){});
     }

     $(document).ready(function() {
            $("#next_button").attr("disabled", true);

            $("#sound").click(function(){
               if(playing){
                  playing=false;
                  $("#sound").removeClass('fa-volume-up');
                  $("#sound").addClass('fa-volume-off');
               }else{
                  playing=true;
                  $("#sound").removeClass('fa-volume-off');
                  $("#sound").addClass('fa-volume-up');
               }
            });

          chart = new Highcharts.Chart("progressao_treino", newSessionChart());
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

                     simulation_live_info(dados[i].maos_corretas, dados[i].recoil, dados[i].frequencia);
                  }
             }
            });
            chart.redraw();
         },100);


         var perfect_BPM = 110;
         var BPM = 60 / perfect_BPM*1000;
         setInterval(function(){
            if(playing){
               snd.play();
            }
         },BPM);
      });

      //Ativa e desativa os butões
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
                      <div class="row">
                        <div class="col-md-4" style="min-width: 32%; float: left;">
                           <div class="panel panel-primary" style="border-color: #f1f1f1;">
                              <div class="panel-heading" style="background: #f1f1f1;color: #000;border-color: #f1f1f1;">
                                  <b><p class="text-center" style='font-size: 20px;' >{{trans('messages.frequence')}}</p></b>
                              </div>
                               <b><p id="frequencia"></p></b>
                               <p id="recomend_frequencia"></p>
                           </div>
                        </div>
                        <div class="col-md-4" style="min-width: 32%; float: left;">
                           <div class="panel panel-primary" style="border-color: #f1f1f1;">
                              <div class="panel-heading" style="background: #f1f1f1;color: #000;border-color: #f1f1f1;">
                                <b><p class="text-center" style='font-size: 20px;' >{{trans('messages.correct_hands')}}</p></b>
                              </div>
                               <b><p id="pos_maos"></p></b>
                               <p id="recomend_pos_maos"></p>
                           </div>
                        </div>
                        <div class="col-md-4" style="min-width: 32%; float: left;">
                           <div class="panel panel-primary" style="border-color: #f1f1f1;">
                              <div class="panel-heading" style="background: #f1f1f1;color: #000;border-color: #f1f1f1;">
                                <b><p class="text-center" style='font-size: 20px;' >{{trans('messages.full_recoil')}}</p></b>
                              </div>
                               <b><p id="recoil"></p></b>
                               <p id="recomend_recoil"></p>
                           </div>
                        </div>
                      </div>
                      <div id="progressao_treino" style="height:45vh;">
                              <!-- GRAFICO HIGHCHARTS -->
                              <!-- GRAFICO HIGHCHARTS -->
                      </div>
                      <div class = "row">
                        <div class="col-md-4">

                           <div class="row">
                                 <div class="col-md-2">
                                       <a href="#" ><i id="sound" class="fa fa-volume-off fa-4x" style="margin-left: 20px;" ></i></a>
                                 </div>
                                 <div class= "col-md-10">
                                    <h4>Auxílio Sonoro para o ritmo das compressões</h4>
                                    <p>Recomendado 100-120/min</p>
                                 </div>
                           </div>
                        </div>

                       <div class = "col-md-4 inputs" style="margin: 0 auto; text-align: center;">
                          <li style="display: inline-block">
                            <input class = "btn btn-default btn-lg fa-input" type="submit" name="filter_button" id="exercise_button" onclick = "exercise()" value="&#xf144;" style="color: green;"/>
                          </li>
                          <li style="display: inline-block">
                             {!! Form::open(
                             array('action'=> array('NewSessionController@newExercise', $id)
                             , 'method'=>'post')) !!}
                             {!! csrf_field() !!}
                             {!! Form::submit('&#xf28b;', ['id'=>'next_button', 'class'=>'fa-input btn btn-default btn-lg', 'style'=>'margin: 0 10px 0 10px;']) !!}

                            {!! Form::close() !!}
                          </li>

                          <li style="display: inline-block">
                             {!! Form::open(
                             array('action'=> array('NewSessionController@endSession', $id)
                             , 'method'=>'post')) !!}
                             {!! csrf_field() !!}
                             {!! Form::submit('&#xf28d;', ['class'=>'fa-input btn btn-default btn-lg', 'style'=>'color: red;']) !!}

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
</div>
@endsection
