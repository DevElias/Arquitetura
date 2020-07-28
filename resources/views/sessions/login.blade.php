<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Sistema Santista Ambiental - Login</title>
        <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet">
        <link rel="stylesheet" href="{{asset('assets/styles/css/themes/lite-purple.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/styles/css/themes/jquery-confirm.css')}}">
    </head>

    <body>
        <div class="auth-layout-wrap" style="background-image: url({{asset('assets/images/photo-wide-4.jpg')}})">
            <div class="auth-content">
                <div class="card o-hidden card-login">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="p-4">
                                <div class="auth-logo text-center mb-4">
                                <img src="{{asset('assets/images/logo.png')}}" class="logo-site" alt="Buriti Arquitetura">
                                </div>
                                <h1 class="mb-3 text-18">Login</h1>
                                <form>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input id="email"
                                            class="form-control form-control-rounded"
                                            name="email"  required autocomplete="email"
                                            autofocus>
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Senha</label>
                                        <input id="senha" type="password"
                                            class="form-control form-control-rounded"
                                            name="password" required autocomplete="current-password">
                                        <span class="invalid-feedback" role="alert">
                                            <strong>ERRO</strong>
                                        </span>
                                    </div>
                                    <div class="form-group padding-top20">
                                        <button type="button" id="login" class="btn btn-rounded btn-primary btn-block mt-2 padding-">Login</button>
                                    </div>
                                </form>

                                <div class="mt-3 text-center">

                                <a href="esqueci" class="text-muted"><u>Esqueceu a senha?</u></a>
                                    <!-- ou
                                <a href="cadastro" class="text-muted"><u>Cadastre-se</u></a-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <link id="gull-theme" rel="stylesheet" href="{{  asset('assets/styles/css/themes/custom.css')}}">
        <script src="{{asset('assets/js/common-bundle-script.js')}}"></script>
        <script src="{{asset('assets/js/script.js')}}"></script>
        <script src="{{asset('assets/js/jquery-confirm.js')}}"></script>
		<script src="{{asset('assets/js/usuario/usuario.js')}}"></script>
    </body>

</html>
