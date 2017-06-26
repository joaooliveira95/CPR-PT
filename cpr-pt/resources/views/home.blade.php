@extends('layouts.app')

@section('highcharts')
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script type="text/javascript" src="{{ URL::to('/js/highcharts.js') }}"></script>

      <script>
            var chart;
            var idUser = {{Auth::user()->id}};
            var title = "{{trans('messages.progress')}}";
            var xTitle = "{{trans('messages.exercises')}}";
            var yTitle = "{{trans('messages.sensor_units')}}";

            $(document).ready(function() {

               var options = {
                        chart: {
                            zoomType: 'x',
                            backgroundColor: null,
                        },
                    title: {
                        text: title
                    },
                    subtitle: {
                        text: document.ontouchstart === undefined ?
                                'Click and drag in the plot area to zoom in' : 'Pinch the chart to zoom in'
                    },

                    xAxis:{
                        type: 'datetime',
                        title: {
                            text: xTitle
                        },
                        categories: [],
                    },

                    yAxis: {
                        title: {
                            text: yTitle
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
                        name: 'Sensor',
                        data: []
                    }]
                };

                var url = "/exercises/"+idUser;
              $.get(url,function(result){

                var dados= jQuery.parseJSON(result);
                var total=dados.recoil.length;
                var i=0;
                for(i=0;i<total;i++){
                  options.series[0].data.push( dados.compress[i] );
                }

                chart = new Highcharts.Chart("compressoes", options);
                chart.xAxis[0].setCategories(dados.dates);

                for(i=0;i<total;i++){
                  options.series[0].data.push( dados.recoil[i] );
                }

                chart = new Highcharts.Chart("recoil", options);
                chart.xAxis[0].setCategories(dados.dates);

                for(i=0;i<total;i++){
                  options.series[0].data.push( dados.hands[i] );
                }

                chart = new Highcharts.Chart("pos_maos", options);
                chart.xAxis[0].setCategories(dados.dates);
              })
            });

    </script>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-md-offset-0">
            <div class="panel panel-default shadow">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">

                     <div id="compressoes" class="progresso">
                     </div>
                     <div id="recoil" class="progresso">
                     </div>
                     <div id="pos_maos" class="progresso">
                     </div>
                  </div>
            </div>
        </div>
    </div>
</div>
@endsection
