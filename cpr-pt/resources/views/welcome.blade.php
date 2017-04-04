<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>CPR PT</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                
             background-image: url("https://lh5.googleusercontent.com/PFAerXKtUqjzX1QCVv1rJ7ntpdBt-8IubEM9PyInP66QglPCqmkcFAWc7IvyAwUNmy7ImO2ZPhR2v7c=w1919-h950-rw");
                background-color: rgba(241, 241, 241, 0.7);
               
                background-repeat: no-repeat;
                background-size: auto 100%;
                background-position: 50% 0%;

                font-family: 'Arial', sans-serif;
                margin: 0;
            }

            @-webkit-keyframes fadeIn {
                0% {opacity: 0;}
                100% {opacity: 1;}
             }
             
             @keyframes fadeIn {
                0% {opacity: 0;}
                100% {opacity: 1;}
             }

            body{

                -webkit-animation-duration: 3s;
                animation-duration: 3s;
                -webkit-animation-fill-mode: both;
                animation-fill-mode: both;
                -webkit-animation-name: fadeIn;
                animation-name: fadeIn;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 5vw;
                font-weight: bold;
            }

            .links > a {
                color: #000000;
                padding: 0 1vh;

                font-size: 1.5vw;
         

                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .links > a:hover {
             color: #444444;
            }

            .m-b-md {
                margin-bottom: 2px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @if (Auth::check())
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ url('/login') }}">Login</a>
                        <a href="{{ url('/register') }}">Register</a>
                    @endif
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                   CPR PT
                </div>

                <div class="links">
                    <a href="https://laravel.com/docs">Cardio Pulmonary Ressuscitation Personal Trainer</a>
                </div>
            </div>
        </div>
    </body>
</html>
