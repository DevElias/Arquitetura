@extends('layouts.master')
@section('main-content')
<div class="breadcrumb">
    <h1>Editar Usuário</h1>
    <ul>
        <li><a href="">Dashboard</a></li>
        <li>Editar Usuário</li>
    </ul>
</div>

<div class="separator-breadcrumb border-top"></div>
<div class="card user-profile mb-4">
<div class="header-cover" style="background-image: url({{asset('assets/images/photo-wide-4.jpg')}})"></div>
                    <div class="user-info"><img class="profile-picture avatar-lg mb-2" src="{{asset('assets/images/faces/custom.png')}}" alt="" />
                        <p class="m-0 text-24"><?php echo($dados->nome);?></p>
                        <p class="text-muted m-0">Meu Perfil</p>
                    </div>
                    <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                        <form method="POST" action="#" id="formulario">
                                    <div class="form-group row">
                                    <div class="col-6">
                                        <label for="nome">Nome Completo *</label>
                                        <input id="nome" type="text"
                                            class="form-control-rounded form-control"
                                            name="nome" value="<?php echo($dados->nome);?>"
                                            autofocus>
                                    </div>
                                    <div class="col-6">
                                        <label for="email">Email *</label>
                                        <input id="email" type="email" disabled="disabled"
                                            class="form-control-rounded form-control"
                                            name="email" value="<?php echo($dados->email);?>"  required autocomplete="email">
                                    </div>

                                    </div>
                                    <div class="form-group row">
                                    <div class="col-6">
                                        <label for="cpf">CPF *</label>
                                        <input id="cpf" type="text"
                                            class="form-control-rounded form-control"
                                            name="cpf" value="<?php echo($dados->cpf);?>"
                                            autofocus>
                                    </div>
                                    <div class="col-6">
                                    <label for="nascimento">Data de Nascimento *</label>
                                        <input id="nascimento" type="text"
                                            class="form-control-rounded form-control"
                                            name="nascimento" value="<?php echo($dados->data_nascimento);?>"  required
                                            autofocus>
                                    </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-6">
                                                <label for="telefone">Telefone *</label>
                                                <input id="telefone" type="text"
                                            class="form-control-rounded form-control"
                                            name="telefone" value="<?php echo($dados->telefone);?>" required
                                            autofocus>
                                            </div>
                                        <div class="col-6">
                                            <label for="whatsapp">Whatsapp *</label>
                                            <input id="whatsapp" type="text"
                                            class="form-control-rounded form-control"
                                            name="whatsapp" value="<?php echo($dados->whatsapp);?>" required
                                            autofocus>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                    <div class="col-3">
                                        <label for="cep">CEP *</label>
                                        <input id="cep" type="text"
                                            class="form-control-rounded form-control"
                                            name="cep" value="<?php echo($dados->cep);?>" required
                                            autofocus>
                                    </div>
                                    <div class="col-9">
                                        <label for="endereco">Endereço *</label>
                                        <input id="endereco" type="text"
                                            class="form-control-rounded form-control"
                                            name="endereco" value="<?php echo($dados->endereco);?>" required
                                            autofocus>
                                    </div>
                                    </div>
                                    <div class="row form-group">
                                    <div class="col-3">
                                        <label for="numero">Numero *</label>
                                        <input id="numero" type="text"
                                            class="form-control-rounded form-control"
                                            name="numero" value="<?php echo($dados->numero);?>" required
                                            autofocus>
                                    </div>
                                    <div class="col-9">
                                        <label for="complemento">Complemento</label>
                                        <input id="complemento" type="text"
                                            class="form-control-rounded form-control"
                                            name="complemento" value="<?php echo($dados->complemento);?>" required
                                            autofocus>
                                    </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="bairro">Bairro *</label>
                                        <input id="bairro" type="text"
                                            class="form-control-rounded form-control"
                                            name="bairro" value="<?php echo($dados->bairro);?>" required
                                            autofocus>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-6">
                                            <label for="cidade">Cidade *</label>
                                            <input id="cidade" type="text"
                                                class="form-control-rounded form-control"
                                                name="cidade" value="<?php echo($dados->cidade);?>" required
                                                autofocus>
                                                <input id="id" type="hidden"
                                            class="form-control-rounded form-control"
                                            name="nome" disabled="disabled" value="<?php echo($dados->id);?>"
                                            autofocus>
                                        </div>
                                        <div class="col-6">
                                        <label for="estado">Estado *</label>
                                            <input id="estado" type="text"
                                                class="form-control-rounded form-control"
                                                name="estado" value="<?php echo($dados->estado);?>" required
                                                autofocus>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                    <div class="col-6">
                                        <label for="senha">Senha *</label>
                                        <input id="senha" type="password"
                                            class="form-control-rounded form-control"
                                            name="senha" value="<?php echo($dados->senha);?>" required>
                                            
                                            <input id="id" type="hidden"
                                            class="form-control-rounded form-control"
                                            name="id" value="<?php echo($dados->id);?>" required>
                                     </div>
                                    </div>
                                    <button type="button" id="atualizar" class="btn btn-primary btn-block btn-rounded mt-3">Atualizar</button>
                                </form>
                            </div>

                        </div>
                    </div>
</div>


@endsection

@section('page-js')
<script src="{{asset('assets/js/vendor/echarts.min.js')}}"></script>
<script src="{{asset('assets/js/es5/echart.options.min.js')}}"></script>
<script src="{{asset('assets/js/es5/dashboard.v1.script.js')}}"></script>
<script src="{{asset('assets/js/jquery.mask.min.js')}}"></script>
<script src="{{asset('assets/js/sistema.js')}}"></script>
<script src="{{asset('assets/js/jquery-confirm.js')}}"></script>
<script src="{{asset('assets/js/usuario/convida.js')}}"></script>
@endsection
