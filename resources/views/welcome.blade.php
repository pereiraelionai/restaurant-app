<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>MineChef</title>
        <link rel="icon" href="{{asset('images/logo.png')}}">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/estilo.css') }}" rel="stylesheet">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            body {
                background: url("{{asset('images/caixa-2.jpg')}}") center no-repeat;
                background-size: cover;
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
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
            .logo{
                padding-top: 160px;
            }
            .display-4{
                color: white;
            }
            #login:hover{
                background-color: #e8c2a6;
            }
            .botao {
                background-color: #e51b23;
                color: white ;
                font-weight: bold;
                font-size: 18px;
                letter-spacing: 1px;
                padding: 10px 110px;
                text-transform: uppercase;
                border-radius: 150px;
                margin: 10px;
            
            }
            .botao:hover {
                background-color: #e98e4b;
                color: white;
                text-decoration: none;
            }
            .ajuste-botao{
                margin-top: 30px;
            }
        </style>
    </head>
    <body>
        <div class=" position-ref full-height login">
            <div class="content logo">
                <div class="title m-b-md">
                    <img src="{{asset('images/logo-minechef.png')}}" alt="">
                </div>
                <h1 class="display-4">Mais controle para o seu negócio!</h1>
                <div class="ajuste-botao">
                    <a href="#" class="botao">Conheça o MineChef</a>
                    @if (Route::has('login'))
                        @auth
                            <a class="botao" href="{{ url('/home') }}">Home</a>
                        @else
                            <a class="botao" href="{{ route('login') }}">Login</a>
                        @endauth
                @endif
                </div>
            </div>
        </div>
    </body>
</html>
