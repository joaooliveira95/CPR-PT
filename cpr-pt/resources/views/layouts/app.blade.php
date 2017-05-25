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
        .glyphicon.glyphicon-envelope {
    font-size: 20px;
}
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

        #progresso_sessao {
            display: none;
            
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

        .centered_tb{
            text-align:center; 
            vertical-align:middle;
        }
    </style>

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

     @yield('highcharts')
  
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>

    <script>
            $(document).ready(function() {
                $(".dropdown-toggle").dropdown();
            });

             
            $(window).on('load', function() {
                var url = "/comments/new";

               $.get(url,function(result){
                    var dados= jQuery.parseJSON(result);
                    var newComments = dados.new_comments;
                    if(newComments>0){
                       $("#ncomments").append("<sup>"+newComments+"</sup>");  
                       $("#ncomments").css('color', 'red');
                    }
                   
                });
              
              
            });


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
                    <li><a href="http://127.0.0.1:8000/newSession" targer="-self"><span>{{trans('messages.new_session')}}</span></a></li>
                        <li><a href="http://127.0.0.1:8000/history" targer="-self"><span>{{trans('messages.history')}}</span></a></li>
                        @if(Auth::user()->role_id==1 || Auth::user()->role_id==3)
                     <!--   <li><a href="http://127.0.0.1:8000/students" targer="-self"><span>Students</span></a></li> -->
                        <li><a href="http://127.0.0.1:8000/turmas/{{Auth::user()->id}}" targer="-self"><span>{{trans('messages.classes')}}</span></a></li>
                        @endif
                         <li><a href="http://127.0.0.1:8000/content" targer="-self"><span>{{trans('messages.content')}}</span></a></li>
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
                        <li>
                            <a id='ncomments' href="/comments/{{Auth::user()->id}}"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span></a>
                         </li>
                         <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                {{ Config::get('languages')[App::getLocale()] }}
                            </a>
                            <ul class="dropdown-menu">
                                @foreach (Config::get('languages') as $lang => $language)
                                    @if ($lang != App::getLocale())
                                        <li>
                                            <a href="{{ route('lang.switch', $lang) }}">{{$language}}</a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    @if(Auth::user()->role_id==1 || Auth::user()->role_id==3)
                                    <li>
                                        <a href="/admin">
                                            Backoffice
                                        </a>
                                    </li>
                                    @endif
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

