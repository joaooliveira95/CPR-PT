@extends('layouts.app')

@section('highcharts')

<script type="text/javascript" src="{{ URL::to('/js/highstock.js') }}"></script>
<script type="text/javascript" src="{{ URL::to('/js/boost.js') }}"></script>
<script type="text/javascript" src="{{ URL::to('/js/simulation_info.js') }}"></script>
<script type="text/javascript" src="{{ URL::to('/js/highcharts_options.js') }}"></script>

      <script>
      var chart;
      var idExercise = "{{$exercise->id}}";
   $(document).ready(function() {
               var options = exerciseFeedbackChart();

                var url = "/exercise_progress/"+idExercise;
              $.get(url,function(result){

                     var dados= jQuery.parseJSON(result);
                     var total=dados.length;

                     var time = 0;
                     for(var i=0;i<total;i++){
                        time = Number(dados[i].time);

                        options.series[0].data.push( [time, Number(dados[i].ponto_sensor1)]);
                        options.series[1].data.push( [time, Number(dados[i].ponto_sensor2)]);

                        options.series[2].data.push( [time, Number(dados[i].picos_sensor1)]);
                        options.series[3].data.push( [time, Number(dados[i].picosSensor2)]);
                     }
                     simulation_feedback(dados[total-1].maos_corretas, dados[total-1].recoil, dados[total-1].frequencia, time);

                     chart = new Highcharts.Chart("treino", options);
                });
              });
    </script>
@endsection

@section('content')
<link href="{{ asset('/css/comentsStyle.css') }}" rel="stylesheet">
<div class="container" style="margin-top: 70px; width: 90vw;">
    <div class="row">
       <div class="col-md-12">
            <div class="panel panel-default shadow">
               <div class="panel-heading">
                  <div class="row">
                     <h3 class="titulo-pages">Feedback {{$exercise->id}}</h3>
                     <ol class="breadcrumb breadcrumbs">
                       <li><a href="/home">Home</a></li>
                       <li><a href="/history">Progress</a></li>
                       <li><a href="/history/sessions">{{trans('messages.sessions')}}</a></li>
                       <li><a href="/history/{{$exercise->idSession}}/session">{{trans('messages.session')}}</a></li>
                       <li class="active">Exercise</li>
                     </ol>
                  </div>
               </div>

            <div class="panel-body">
              <div id="tempo_treino" class="col-md-4">
                 <h4><center><b>{{trans('messages.time')}}</b></center></h4>
                <div class="table-responsive">
                 <table id="table_1" class='table table-hover'>
                    <br>
                    <thead class="thead-default">
                      <tr class="tabela_header">
                        <th class = "centered_tb ">{{trans('messages.total_time')}}</th>
                        <th class = "centered_tb">Compress. {{trans('messages.time')}}</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td id="tempo" class = "centered_tb"></td>
                        <td class = "centered_tb tabela_simples">{{$exercise->time}} s</td>
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
                          <tr class="tabela_header">
                              <th class = "centered_tb">{{trans('messages.frequence')}}</th>
                              <th class = "centered_tb">{{trans('messages.full_recoil')}}</th>
                              <th class = "centered_tb">{{trans('messages.correct_hands')}}</th>
                          </tr>
                      </thead>

                      <tbody>
                        <tr>
                            <td id="frequencia" class = "centered_tb" style="color:green"></td>
                            <td id="recoil" class = "centered_tb" style="color:red"></td>
                            <td id="pos_maos" class = "centered_tb"></td>
                        </tr>
                      </tbody>
                  </table>
                  </div>
            </div>

             <div id="treino" class="col-md-12" style="height:60vh;"></div>

              <div id="disqus_thread" class="col-md-12"></div>
               <script>

               /**
               *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
               *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables*/
               /*
               var disqus_config = function () {
               this.page.url = PAGE_URL;  // Replace PAGE_URL with your page's canonical URL variable
               this.page.identifier = PAGE_IDENTIFIER; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
               };
               */
               (function() { // DON'T EDIT BELOW THIS LINE
               var d = document, s = d.createElement('script');
               s.src = 'https://cprpt.disqus.com/embed.js';
               s.setAttribute('data-timestamp', +new Date());
               (d.head || d.body).appendChild(s);
               })();
               </script>
               <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
               </div>
            </div>
        </div>
    </div>
</div>

@endsection
