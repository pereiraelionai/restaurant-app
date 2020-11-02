<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/estilo.css') }}" rel="stylesheet">

    <style>
        html, body {
            height: 100%;
          }
          
          body {
              font-family: "Segoe UI", Arial, sans-serif;
          }          
          .banner {
              height: 100%;
              background-color: #e98e4b;
          }
          .communicationItem {
              color: #fff;
              display: -moz-box;
              display: -ms-flexbox;
              display: flex;
              font-size: 18px;
              font-weight: bold;
              line-height: 24px;
              margin: 48px auto;
              position: relative;
          }
          .image{
            display: -moz-box;
            display: -ms-flexbox;
            display: flex;
            margin: 48px auto;
            position: relative;
          }
          .login {
            margin: 300px auto;
          }
          .btn-primary {
              background-color: #e98e4b;
              border-color: #e98e4b;
              color: white
          }
          .btn-primary:hover {
            background-color: #ecb083;
            border-color: #ecb083;
            color: white
        }
        .btn-link{
            color: #e98e4b;
        }
        .btn-link:hover{
            color: #ecb083
        }
        .display-4{
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container-fluid h-100">
        <div class="row h-100">
        
        <div class="col-md-6 banner">

            <div class="row h-100 justify-content-center align-items-center">
                <div>
                    <img class="image" src="{{asset('images/logo.png')}}" alt="">
                    <div class="communicationItem">
                        <i class="fas fa-utensils fa-2x mr-3"></i>
                        Cadastre seu cardápio por categorias.
                    </div>
                    <div class="communicationItem">
                        <i class="fas fa-tablet-alt fa-2x mr-3"></i>
                        Registre os pedidos via tablet.
                    </div>
                    <div class="communicationItem">
                        <i class="fas fa-cash-register fa-2x mr-3"></i>
                        Tenha o controle total do seu caixa.
                    </div>
                </div>
            </div>

        </div>
    
        <div class="col-md-6 pt-4 pl-5 pr-5">
            <h2 class="display-4">Inicie essa experiência conosco!</h2>
            <div class="login">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group row">
                        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail') }}</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Senha') }}</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6 offset-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    {{ __('Lembrar seu usuário') }}
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Login') }}
                            </button>

                            @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Esqueceu sua senha?') }}
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
    
        </div>
    
      </div>
    </div>
</body>
</html>