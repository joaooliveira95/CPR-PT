@extends('layouts.app')

@section('highcharts')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
      <script>
      var chart;
   $(document).ready(function() {
        chart = new Highcharts.chart('progressao_treino', {
            chart: {
                type: 'spline',
                animation: Highcharts.svg, // don't animate in old IE
                marginRight: 10,
            },
            title: {
                text: 'Live Simulation Data'
            },
            xAxis: {
                type: 'datetime',
                tickPixelInterval: 150,
                softMax : 3
            },
            yAxis: {
                softMax: 150,
                title: {
                    text: 'Compressions (BPM)'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                formatter: function () {
                    return '<b>' + this.series.name + '</b><br/>' ;
                       
                       
                }
            },
            legend: {
                enabled: false
            },
            exporting: {
                enabled: true
            },
            series: [{
                name: 'Random data',
                data: []
            }]
        });
    });

            function setIntervalLimited(callback, interval, x) {
                flag = 0;

                for (var i = 0; i < x; i++) {

                    setTimeout(callback, i * interval);
                    
                }
                if(i>=x){
                    flag=1;
                }
                return flag;

            }

            function exercise(curExercise){
                    var time = Math.round(new Date() / 1000 -1);
                    var perfect_BPM = 110;
                    var BPM = 60 / perfect_BPM*1000;
                     var snd = new Audio('http://127.0.0.1:8000/storage/beep.mp3');

                    setIntervalLimited(function(){
                        $.post("{{ asset('script.php') }}",
                            {exercise:curExercise, time:time}, 
                            function(response){
                                $("#exercise_button").attr("disabled", true);
                                //alert(response);
                            });
                     },1000, 20); 

                   


                    setIntervalLimited(function(){
                      var url = "/exercise_progress/"+curExercise;
                      var compress = 0;
                      var recoil = 0;
                      $.get(url,function(result){
                      
                        var dados= jQuery.parseJSON(result);
                        compress = Number(dados.compress);
                        recoil = Number(dados.recoil);

                        if(compress>=100 && compress <= 120){
                            chart.series[0].addPoint({marker:{fillColor:'#659355'}, y: compress, color:'#659355', name:"POIS"});
                        }else{
                             chart.series[0].addPoint({marker:{fillColor:'#fc1000'}, y: compress, color:'#fc1000'});
                        }
                      });

                        
                    },1000,22);

                    /*setInterval(function(){
                        snd.play();
                    },BPM);*/


            }
    </script>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Exercise {{$curExercise->id}}</div>

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
                             array('action'=> array('NewSessionController@newExercise', $id)
                             , 'method'=>'post')) !!}

                             {!! Form::submit('New Exercise', ['class'=>'btn btn-default btn-sm']) !!}

                            {!! Form::close() !!}
                          </li>

                          <li style="display: inline-block">
                            <input class = "btn btn-danger btn-sm" type="submit" name="filter_button" id="filter_button" value="End Session" onclick="location.href='/history';"/>
                          </li>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
