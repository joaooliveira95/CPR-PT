<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        
        .navbar-default .navbar-brand {
            color: rgb(213, 55, 69);
            font-weight: bold;
        }

        .video-container {
        position: relative;
        padding-bottom: 56.25%;
        padding-top: 30px; height: 0; overflow: hidden;
        }

        .video-container iframe,
        .video-container object,
        .video-container embed {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        }

        #container {
            min-width: 310px;
            max-width: 800px;
            height: 400px;
            margin: 0 auto
        }
        body{

            font-family: "Open Sans", Arial, sans-serif;;
             background-color: rgba(241, 241, 241, 0.7);
            background-image: url('http://127.0.0.1:8000/storage/pictures/logo.png');
            background-repeat: no-repeat;
            background-size: 70%;
            background-position: 50% 0%;
            
            text-rendering: optimizeLegibility;
    -webkit-font-smoothing: antialiased;
        }

        .navbar{
            font-family: "Open Sans", Arial, sans-serif;;
            background: white;
            border-color: #ffffff;
        }

        .panel{
            background-color: rgba(255, 255, 255, 0.97);
        }

        .panel-default>.panel-heading {
            color: rgb(213, 55, 69);
            font-weight: bold;
            border-color: rgba(241, 241, 241, 0.7);
        }

        .panel-default {
            border-color: #ffffff;
        }

        .panel-heading{

            background: white;
        }

        .panel-body {
            padding: 15px;
        }

        .table-borderless > tbody > tr > td,
.table-borderless > tbody > tr > th,
.table-borderless > tfoot > tr > td,
.table-borderless > tfoot > tr > th,
.table-borderless > thead > tr > td,
.table-borderless > thead > tr > th {
    border: none;
}
    </style>

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="https://code.highcharts.com/stock/highstock.js"></script>
    <script src="https://code.highcharts.com/stock/modules/exporting.js"></script>

  
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>

    <script>

            function setIntervalLimited(callback, interval, x) {

                for (var i = 0; i < x; i++) {

                    setTimeout(callback, i * interval);
                }

            }

            function exercise(curExercise){
                     
                 $(document).ready(function(){
                    $('#exercise_button').click(function(){
                        var time = new Date().getTime() / 1000;
                        $("#exercise_button").attr("disabled", true);

                        setIntervalLimited(function(){

                            $.post("{{ asset('script.php') }}",
                                {exercise:curExercise,
                                 beg_time:time}, 
                                function(response){
                                //    alert(response);
                                    $("#exercise_button").attr("disabled", true);
                                });
                           },1000, 10);  

                        });

                    setInterval(function(){
                        $('#info').load("{{ asset('fetch.php') }}", {exercise:curExercise}).fadeIn("slow");
                    },1000);
                
                    
                });
            }



            function filterDates(id){
                var from = document.getElementById("from").value;
                var to = document.getElementById("to").value;
            }

            function filterStudents(id){
                var filter = document.getElementById("str_filter").value;

                var url = "/students?filter="+filter;
                return url;
            }




    </script>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/home') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    @if(Auth::guest())

                    @else 
                    <ul class="nav navbar-nav">
                    <li><a href="http://127.0.0.1:8000/newSession" targer="-self"><span>New Session</span></a></li>
                        <li><a href="http://127.0.0.1:8000/history" targer="-self"><span>History</span></a></li>
                        @if(Auth::user()->role_id==1 || Auth::user()->role_id==3)
                        <li><a href="http://127.0.0.1:8000/students" targer="-self"><span>Students</span></a></li>
                        @endif
                         <li><a href="http://127.0.0.1:8000/content" targer="-self"><span>Content</span></a></li>
                        </li>
                    </ul>
                    @endif

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>

