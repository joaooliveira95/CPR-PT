@extends('layouts.app')

@section('highcharts')
<script type="text/javascript" src="{{ URL::to('/js/highcharts.js') }}"></script>

      <script>
             var idSession = "{{$session->id}}";
             $(document).ready(function() {
             
               var options = {

                    title: {
                        text: 'Progresso da Sessão'
                    },

                    subtitle: {
                        text: 'CPR PT'
                    },

                    xAxis:{
                       allowDecimals: false,
                      title: {
                            text: 'Treinos'
                        }
                    },

                    yAxis: {

                        title: {
                            text: 'Unidades do sensor'
                        }
                    },
                    legend: {
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'middle'
                    },

                    plotOptions: {
                      
                        series: {
                            pointStart: 0
                        }
                    },

        
                    series: [{
                        name: 'Tempo (s)',
                        data: []
                    },{
                        name: 'Recoil',
                        data: []
                    }, {
                        name: 'Compressões',
                        data: []
                    }, {
                        name: 'Pos. Mãos (%)',
                        data: []
                    }]
                    
                };

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
<div class="container no_overflow">
    <div class="row">
       <div class="col-md-12" style="padding-right: 0;">
            <div class="panel panel-default">
                <div class="panel-heading">{{$user->name}} | {{$session->title}} | {{$session->created_at}}</div>

                <div class="panel-body">

                  <div id="treinos">
                          @if($exercises!=null)
                            <div class="table-responsive">
                             <table id="sessions_table" class='table table-hover'>
                                   <br>
                                  <thead class="thead-default">
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
                                          <tr>
                                            <td class = "centered_tb"><a href="/exercise_results/{{$exercise->id}}"> {{$exercise->id}} </a></td>
                                            <td class = "centered_tb">{{$exercise->time}}</td>
                                            <td class = "centered_tb">{{$exercise->recoil}}</td>
                                            <td class = "centered_tb">{{$exercise->compressions}}</td>
                                            <td class = "centered_tb">{{$exercise->hand_position}}</td>
                                          </tr>
                                      @endforeach
                                  </tbody>
                          </table>

                          
                      </div>
                        {{$exercises->links()}}
                  </div>

                  <div id="progresso_sessao_grafico"></div>
                    @endif
                    
        
                 <!--  </div>panel body-->

            <!--</div>panel-->
           
       <!-- </div>Lado esquerdo-->

      <!--  <div class="col-md-3" >
                   <div class="panel panel-default" >
         <div class="panel-body">-->
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
@endsection

