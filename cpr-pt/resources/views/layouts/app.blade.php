<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="/heart_md.png">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('bootstrap-datepicker-1.6.4-dist/css/bootstrap-datepicker.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome-4.7.0/font-awesome-4.7.0/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dropdowns-enhancement.min.css') }}" rel="stylesheet">
    <style>
    @import url('https://fonts.googleapis.com/css?family=Lato:300,400');
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

        body{
            font-weight: 500;
            font-family: 'Lato', Arial;
            background-color: rgba(241, 241, 241, 0.7);
            background-image: url('/logo2.png');
            background-repeat: no-repeat;
            background-size: 70%;
            background-position: 50% 0%;

            text-rendering: optimizeLegibility;
            -webkit-font-smoothing: antialiased;
        }

        .brand-centered {
           display: flex;
           justify-content: center;
           position: absolute;
           width: 100%;
           left: 0;
           top: 0;
         }
         .brand-centered .navbar-brand {
           display: flex;
           align-items: center;
         }
         .navbar-toggle {
             z-index: 1;
         }

         .navbar-alignit .navbar-header {
         	  -webkit-transform-style: preserve-3d;
           -moz-transform-style: preserve-3d;
           transform-style: preserve-3d;
           height: 50px;
         }
         .navbar-alignit .navbar-brand {
         	top: 50%;
         	display: block;
         	position: relative;
         	height: auto;
         	transform: translate(0,-50%);
         	margin-right: 15px;
           margin-left: 15px;
         }

         .navbar-nav>li>.dropdown-menu {
         	z-index: 9999;
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

        .divider {
            height: 30px;
            margin: 10px 1px;
            border-right: 1px solid #ffffff;
            border-left: 1px solid #f2f2f2;
        }
        .norm_shadow {
            font-family: 'Lato', Arial;
            font-weight: 300;
            font-size: 15px;
        }

        .drop_link{
            font-weight: 300;
            font-family: 'Lato', Arial;
            font-size: 15px;
        }

        .drop_shadow{
            font-family: 'Lato', Arial;
            font-weight: 300;
            font-size: 15px;
        }
        .norm_shadow:hover i {
            color: #B23838;
        }
        .drop_shadow:hover i {
            color: #B23838;
        }
        .drop_link:hover i {
            color: #B23838;
        }

        @keyframes example {
            0%   {width:48px; height:48px;}
            25%  {width:60px; height:60px;}
            50%  {width:48px; height:48px;}
            75%  {width:60px; height:60px;}
            100% {width:48px; height:48px;}
        }

        .heart:hover {
            animation-name: example;
            animation-duration: 0.5s;
        }

        .nav_icon{
            padding-right: 10px;
        }

        .fa-input{
             font-family: FontAwesome, 'Helvetica Neue', Helvetica, Arial, sans-serif;
        }

        .box {
         width: 25%;
         float: left;
         margin: 20px 10px;
         padding: 10px;
         text-align: center;
         background: #f1f1f1;
         border: 1px 1px 1px;
         border-style: solid;
         border-color: transparent #fff #fff;
         border-radius: 7px;
         box-shadow: 0 3px 6px rgba(0, 0, 0, 0.3), inset 1px 0 1px rgba(255, 255, 255, 0.1), inset 0 1px 1px rgba(255, 255, 255, 0.1);
        }
         .shadow{
            -webkit-box-shadow: 0px 4px 12px -4px rgba(0,0,0,0.75);
            -moz-box-shadow: 0px 4px 12px -4px rgba(0,0,0,0.75);
            box-shadow: 0px 4px 12px -4px rgba(0,0,0,0.75);
         }

         </style>

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>-->
    <script type="text/javascript" src="{{ URL::to('bootstrap-datepicker-1.6.4-dist/js/bootstrap-datepicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::to('bootstrap-datepicker-1.6.4-dist/locales/bootstrap-datepicker.pt.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/dropdowns-enhancement.js') }}"></script>
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

            $("#collapse_button").click(function(){
               if($("#important-id-for-collapsing").attr('class')=="collapse navbar-collapse out"){
                  $("#important-id-for-collapsing").attr('class')="collapse navbar-collapse in";
                  $(".navbar-toggle").attr('aria-expanded')="true";
               }else{
                  $("#important-id-for-collapsing").attr('class')="collapse navbar-collapse out";
                  $(".navbar-toggle").attr('aria-expanded')="false";
               }
            });

            /*$(window).on('load', function() {
                var url = "/comments/new";

               $.get(url,function(result){
                    var dados= jQuery.parseJSON(result);
                    var newComments = dados.new_comments;
                    if(newComments>0){
                       $("#ncomments").append("<sup>"+newComments+"</sup>");
                       $("#ncomments").css('color', 'red');
                    }
                });
            });*/

            function filterStudents(id){
                var filter = document.getElementById("str_filter").value;
                var url = "/students?filter="+filter;
                return url;
            }

    </script>
</head>
<body>
    <div id="app">
      <div class="container">
          <nav class="navbar navbar-default navbar-fixed-top">
           <div class="container-fluid">
               <div class="navbar-header">
                           <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#important-id-for-collapsing">
                   <span id="collapse_button" class="fa fa-bars"></span>
                </button>
               </div>

               <div class="brand-centered">
               <a class="navbar-brand" href="{{ url('/home') }}"><img class="heart" style="margin-right: 2px; padding: 0;" src="/heart_sm.png" alt="Heart">{{ config('app.name', 'Laravel') }}
               </a>
               </div>

              <div class="collapse navbar-collapse out" id="important-id-for-collapsing">
                   <!-- Left Side Of Navbar -->
                  @if(Auth::guest())

                  @else
                  <ul class="nav navbar-nav navbar-left">
                 <li><a href="/newSession" targer="-self" class="norm_shadow"><span><i class="fa fa-heartbeat nav_icon" aria-hidden="true"></i>{{trans('messages.session')}}</span></a></li>
                     <li><a href="/history/sessions" targer="-self" class="norm_shadow"><span><i class="fa fa-history nav_icon" aria-hidden="true"></i>{{trans('messages.history')}}</span></a></li>
                     @if(Auth::user()->role_id==1 || Auth::user()->role_id==3)
                  <!--   <li><a href="/students" targer="-self"><span>Students</span></a></li> -->
                     <li><a href="/turmas" targer="-self" class="norm_shadow"><span><i class="fa fa-users nav_icon" aria-hidden="true"></i>{{trans('messages.classes')}}</span></a></li>
                     @endif
                 </ul>
                 @endif

                 <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ route('login') }}" class="norm_shadow">Login</a></li>
                        <li><a href="{{ route('register') }}" class="norm_shadow">Register</a></li>
                    @else
                    <li>
                        <a id='ncomments' href="/discussion" class="norm_shadow"><i class="fa fa-envelope-o nav_icon" aria-hidden="true"></i>Discussions</a>
                     </li>
                     <li><a href="/content" targer="-self" class="norm_shadow"><span><i class="fa fa-play-circle nav_icon" aria-hidden="true"></i>Media</span></a></li>
                    </li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle drop_shadow" data-toggle="dropdown" role="button" aria-expanded="false">
                                <i class="fa fa-user nav_icon"></i>{{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                @if(Auth::user()->role_id==1 || Auth::user()->role_id==3)
                                <li>
                                    <a href="/admin" class="drop_link">
                                       <i class="fa fa-lock" aria-hidden="true"></i> Backoffice
                                    </a>
                                </li>
                                @endif
                                <li>
                                    <a href="{{ route('logout') }}" class="drop_link"
                                        onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                       <i class="fa fa-sign-out" aria-hidden="true"></i> Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>



                                <li class="dropdown-submenu">
                                  <a href="#" class="dropdown-toggle drop_shadow" data-toggle="dropdown">

                                     <img src="/{{App::getLocale()}}.png" height="20"> {{ Config::get('languages')[App::getLocale()] }}
                                  </a>
                                  <ul class="dropdown-submenu pull-left">
                                      @foreach (Config::get('languages') as $lang => $language)
                                          @if ($lang != App::getLocale())
                                              <li>
                                                  @if($language == "en")
                                                  <a href="{{ route('lang.switch', $lang) }}" class="drop_link"><img src="/en.png" width="25" class="nav_icon">&nbsp;&nbsp;{{$language}}</a>
                                                  @endif
                                                  @if($language == "pt")
                                                  <a href="{{ route('lang.switch', $lang) }}" class="drop_link"><img src="/pt.png" width="25" class="nav_icon">{{$language}}</a>
                                                  @endif
                                              </li>
                                          @endif
                                      @endforeach
                                  </ul>
                                 </li>


                            </ul>
                        </li>
                    @endif
                </ul>
               </div>
               <!--/.nav-collapse -->
           </div>
           <!--/.container-fluid -->
          </nav>
          </div>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
