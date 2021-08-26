<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>App Buriti Arquitetura - Cadastro</title>
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

                                <div class="auth-logo text-center mt-4">
                                    <img src="{{asset('assets/images/logo.png')}}" class="logo-site" alt="Buriti Arquitetura">
                                </div>
                                <h1 class="mb-3 text-18">Cadastre-se</h1>
                                <form method="POST" action="#">
                                    <div class="form-group row">
                                    <div class="col-12 col-md-6">
                                        <label for="nome">Nome Completo *</label>
                                        <input id="nome" type="text"
                                            class="form-control-rounded form-control"
                                            name="nome" required autocomplete="name"
                                            autofocus>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label for="email">Email *</label>
                                        <input id="email" type="email"
                                            class="form-control-rounded form-control"
                                            name="email" required autocomplete="email">
                                    </div>

                                    </div>
                                    <div class="form-group row">
                                    <div class="col-12 col-md-6">
                                        <label for="cpf">CPF *</label>
                                        <input id="cpf" type="text"
                                            class="form-control-rounded form-control"
                                            name="cpf"  required
                                            autofocus>
                                    </div>
                                    <div class="col-12 col-md-6">
                                    <label for="nascimento">Data de Nascimento *</label>
                                        <input id="nascimento" type="text"
                                            class="form-control-rounded form-control"
                                            name="nascimento" required
                                            autofocus>
                                    </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-12 col-md-6">
                                                <label for="tel">Telefone *</label>
                                                <input id="telefone" type="text"
                                            class="form-control-rounded form-control"
                                            name="telefone" required
                                            autofocus>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label for="whats">Whatsapp *</label>
                                            <input id="whatsapp" type="text"
                                            class="form-control-rounded form-control"
                                            name="whatsapp" required
                                            autofocus>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                    <div class="col-12 col-md-3">
                                        <label for="cep">CEP *</label>
                                        <input id="cep" type="text"
                                            class="form-control-rounded form-control"
                                            name="cep" required
                                            autofocus>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <label for="endereco">Endereço *</label>
                                        <input id="endereco" type="text"
                                            class="form-control-rounded form-control"
                                            name="endereco" required
                                            autofocus>
                                    </div>
                                    </div>
                                    <div class="row form-group">
                                    <div class="col-12 col-md-3">
                                        <label for="numero">Numero *</label>
                                        <input id="numero" type="text"
                                            class="form-control-rounded form-control"
                                            name="numero" required
                                            autofocus>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <label for="complemento">Complemento</label>
                                        <input id="complemento" type="text"
                                            class="form-control-rounded form-control"
                                            name="complemento" required
                                            autofocus>
                                    </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="bairro">Bairro *</label>
                                        <input id="bairro" type="text"
                                            class="form-control-rounded form-control"
                                            name="bairro" required
                                            autofocus>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-12 col-md-6">
                                            <label for="cidade">Cidade *</label>
                                            <input id="cidade" type="text"
                                                class="form-control-rounded form-control"
                                                name="cidade" required
                                                autofocus>
                                        </div>
                                        <div class="col-12 col-md-6">
                                        <label for="estado">Estado *</label>
                                            <input id="estado" type="text"
                                                class="form-control-rounded form-control"
                                                name="estado" required
                                                autofocus>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                    <div class="col-12 col-md-6">
                                        <label for="password">Senha *</label>
                                        <input id="senha" type="password"
                                            class="form-control-rounded form-control"
                                            name="senha" required>
                                     </div>
                                     <div class="col-12 col-md-6">
                                        <label for="password">Confirmar Senha *</label>
                                        <input id="password" type="password"
                                            class="form-control-rounded form-control"
                                            name="password" required>
                                     </div>

                                    </div>
                                    <button type="button" id="gravar" class="btn btn-primary btn-block btn-rounded mt-3">Cadastrar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <link id="gull-theme" rel="stylesheet" href="{{  asset('assets/styles/css/themes/custom.css')}}">
        <script src="{{asset('assets/js/common-bundle-script.js')}}"></script>
        <script src="{{asset('assets/js/jquery-confirm.js')}}"></script>
        <script src="{{asset('assets/js/jquery.mask.min.js')}}"></script>
		<script src="{{asset('assets/js/usuario/usuario.js')}}"></script>
        <script src="{{asset('assets/js/script.js')}}"></script>
        <script src="{{asset('assets/js/sistema.js')}}"></script>

    </body>

</html>
