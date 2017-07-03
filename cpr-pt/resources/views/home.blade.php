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
                        text: null
                    },

                    xAxis:{
                        type: 'datetime',
                        title: {
                            text: xTitle
                        },
                        categories: [],
                        tickInterval: 1000,
                    },

                    yAxis: {
                        title: {
                            text: yTitle
                        },

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

                var dados = jQuery.parseJSON(result);
                options.series[0].data = dados.compress.reverse();
                options.series[0].name = "Compressions (BPM)";
                options.xAxis.categories = dados.dates.reverse();
                chart = new Highcharts.Chart("compressoes", options);

               options.series[0].data = dados.recoil.reverse();
               options.series[0].name = "Recoil (%)";
                  options.series[0].color = '#FF0000';
               options.xAxis.categories = dados.dates.reverse();
               chart = new Highcharts.Chart("recoil", options);

               options.series[0].data = dados.hands.reverse();
               options.xAxis.categories = dados.dates.reverse();
                  options.series[0].color = '#00FF00';
               options.series[0].name = "Hand Position (%)";
               chart = new Highcharts.Chart("pos_maos", options);

              })
            });

    </script>
@endsection

@section('content')
<div class="container" style="width:90vw;">
    <div class="row">
        <div class="col-md-12 ">
            <div class="panel panel-default shadow">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                      <div class="row">
                           <div id="compressoes" class="col-md-4" style="height:45vh;">
                           </div>
                           <div id="recoil" class="col-md-4" style="height:45vh;">
                           </div>
                           <div id="pos_maos" class="col-md-4" style="height:45vh;">
                           </div>
                     </div>
                  </div>
            </div>
        </div>
    </div>
</div>
@endsection
