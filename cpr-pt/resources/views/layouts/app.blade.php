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
            font-weight: bold;http://www.mtv.pt/#carousel-2zxdsc
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
            background-image: url('http://127.0.0.1:8000/storage/pictures/NpqWPOsS0p4JyCDiirUOBES7LEvRAxRukDWgKDHZ.png');
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
    </style>

    <!-- Scripts -->

    <script src="https://code.highcharts.com/stock/highstock.js"></script>
    <script src="https://code.highcharts.com/stock/modules/exporting.js"></script>


    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
    <script>

            function filterDates(id){
                var from = document.getElementById("from").value;
                var to = document.getElementById("to").value;
            }

            function filterStudents(id){
                var filter = document.getElementById("str_filter").value;

                var url = "/students?filter="+filter;
                return url;
            }

            function comment(idUser, idSession){


                $con = mysqli_connect("localhost","root", "cpr");

                if(mysqli_connect_errno()){
                    echo"Failed to connect to MySQL: ", mysqli_connect_error();
                }

                $sql="INSERT INTO comments (idUser, idSession, title, comment) VALUES ('$idUser', '$idSession', '$title', '$comment')";

                if (!mysqli_query($con,$sql)) {
                  die('Error: ' . mysqli_error($con));
                }
                echo "1 record added";

                mysqli_close($con);
            }




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
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    @if(Auth::guest())

                    @else 
                        @if(Voyager::can('browse_sessions'))
                            <?= menu('teachers_menu', 'bootstrap'); ?>
                        @else
                            <?= menu('students_menu', 'bootstrap'); ?>
                        @endif
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
