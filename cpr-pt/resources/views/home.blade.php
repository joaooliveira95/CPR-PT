@extends('layouts.app')

@section('highcharts')
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
      <script>
            var chart;
            var idUser = {{Auth::user()->id}};
            $(document).ready(function() {
             
               var options = {

                        chart: {
                            zoomType: 'x'
                        },

                    title: {
                        text: 'Progress'
                    },

                    subtitle: {
                        text: document.ontouchstart === undefined ?
                                'Click and drag in the plot area to zoom in' : 'Pinch the chart to zoom in'
                    },

                    xAxis:{
                        type: 'datetime',
                      title: {
                            text: 'Exercises'
                        },
                        categories: [],
                    },

                    yAxis: {

                        title: {
                            text: 'Sensor Units'
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
                        name: 'Time (s)',
                        data: []
                    },{
                        name: 'Recoil',
                        data: []
                    }, {
                        name: 'Compressions (BPM)',
                        data: []
                    }, {
                        name: 'Hand Position (%)',
                        data: []
                    }]
                    
                };

                var url = "/exercises/"+1;
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
                chart = new Highcharts.Chart("progresso", options);
                chart.xAxis[0].setCategories(dados.dates);
              })
            });
    
    </script>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-md-offset-0">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    You are logged in!
                    <div id="progresso" class="progresso">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
