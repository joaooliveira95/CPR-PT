@extends('layouts.app')

@section('highcharts')
<script type="text/javascript" src="{{ URL::to('/js/highcharts.js') }}"></script>
<script type="text/javascript" src="{{ URL::to('/js/highcharts_options.js') }}"></script>
      <script>
             var idSession = "{{$session->id}}";
             $(document).ready(function() {

               var options = sessionChart();
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
                chart = new Highcharts.Chart("progresso_sessao_grafico", options);
              });
            });
    </script>
@endsection

@section('content')
<link href="{{ asset('/css/comentsStyle.css') }}" rel="stylesheet">
<div class="container no_overflow" style="margin-top: 70px;">
    <div class="row">
       <div class="col-md-12" style="padding-right: 0;">
            <div class="panel panel-default shadow">
                <div class="panel-heading">
                   <div class="row">
                      <ul class="list-inline session_list">
                       <li class="nome_session">{{$user->name}}</li>
                       <li class="titulo_session"><b>{{$session->title}}</b></li>
                       <li class="data_session">{{date('d M Y' ,strtotime($session->created_at))}}</li>
                     </ul>
                     <ol class="breadcrumb breadcrumbs">
                       <li><a href="/home">Home</a></li>
                       <li><a href="/history/{{$session->idUser}}">Progress</a></li>
                       <li><a href="/sessions/{{$session->idUser}}">Sessions</a></li>
                       <li class="active">{{$session->title}}</li>
                     </ol>
                  </div>
                </div>

                <div class="panel-body">

                  <div id="treinos">
                          @if($exercises!=null)
                            <div class="table-responsive">
                             <table id="sessions_table" class='table table-hover'>
                                   <br>
                                  <thead class="thead-default tabela_header">
                                      <tr>
                                          <th class = "centered_tb">{{trans('messages.exercise')}}</th>
                                          <th class = "centered_tb">{{trans('messages.time')}}</th>
                                          <th class = "centered_tb">Recoil</th>
                                          <th class = "centered_tb">{{trans('messages.compressions')}}</th>
                                          <th class = "centered_tb">{{trans('messages.hands_position')}}</th>
                                      </tr>
                                  </thead>

                                  <tbody>
                                      @foreach($exercises as $exercise)
                                          <tr style="font-size: 16px;">
                                            <td class = "centered_tb tabela_link"><a href="/exercise_results/{{$exercise->id}}"> {{ date("H:i:s", strtotime($exercise->created_at))}} </a></td>
                                            <td class = "centered_tb">{{$exercise->time}} s</td>
                                            <td class = "centered_tb">{{$exercise->recoil}} %</td>
                                            <td class = "centered_tb">{{$exercise->compressions}} BPM</td>
                                            <td class = "centered_tb">{{$exercise->hand_position}} %</td>
                                          </tr>
                                      @endforeach
                                  </tbody>
                          </table>


                      </div>

                  </div>

               <!--   <div id="progresso_sessao_grafico" style="height: 30vh;"></div>-->
                    @endif


                 <!--  </div>panel body-->

            <!--</div>panel-->

       <!-- </div>Lado esquerdo-->

      <!--  <div class="col-md-3" >
                   <div class="panel panel-default" >
         <div class="panel-body">-->
         <br />
         <div id="disqus_thread"></div>
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
        </div><!--PANNNEEEL-->
        </div><!--Lado Direito-->
    </div><!--Row-->
</div><!--Container-->
<script>
    $(document).ready(function(){
          $('.table').DataTable();
    });
</script>
@endsection
