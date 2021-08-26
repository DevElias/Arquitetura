@extends('layouts.master')
@section('main-content')
<div class="breadcrumb">
    <h1>Nova Empresa</h1>
    <ul>
        <li><a href="">Dashboard</a></li>
        <li>Nova Empresa</li>
    </ul>
</div>

<div class="separator-breadcrumb border-top"></div>
<div class="card ">
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <form method="POST" action="#">
                    <div class="form-group row">
                        <div class="col-6">
                            <label for="fantasia">Nome Fantasia *</label>
                            <input id="fantasia" type="text"
                                class="form-control-rounded form-control"
                                name="fantasia"  required
                                autofocus>
                        </div>
                        <div class="col-6">
                            <label for="social">Razão Social *</label>
                            <input id="social" type="text"
                                class="form-control-rounded form-control"
                                name="social"  required
                                autofocus>
                        </div>

                    </div>
                    <div class="form-group row">
                        <div class="col-6">
                            <label for="cnpj">CNPJ *</label>
                            <input id="cnpj" type="text"
                                class="form-control-rounded form-control"
                                name="cnpj"  required
                                autofocus>
                        </div>
                        <div class="col-6">
                            <label for="email">Email *</label>
                            <input id="email" type="email"
                                class="form-control-rounded form-control"
                                name="email"  required autocomplete="email">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-6">
                                <label for="tel">Telefone *</label>
                                <input id="tel" type="text"
                            class="form-control-rounded form-control"
                            name="tel"  required
                            autofocus>
                            </div>
                        <div class="col-6">
                            <label for="whats">Whatsapp</label>
                            <input id="whats" type="text"
                            class="form-control-rounded form-control"
                            name="whats"  required
                            autofocus>
                        </div>
                    </div>
                    <div class="form-group row">
                    <div class="col-3">
                        <label for="cep">CEP *</label>
                        <input id="cep" type="text"
                            class="form-control-rounded form-control"
                            name="cep" required
                            autofocus>
                    </div>
                    <div class="col-6">
                        <label for="endereco">Endereço *</label>
                        <input id="endereco" type="text"
                            class="form-control-rounded form-control"
                            name="endereco" required
                            autofocus>
                    </div>
                    <div class="col-3">
                        <label for="numero">Numero *</label>
                        <input id="numero" type="text"
                            class="form-control-rounded form-control"
                            name="numero" required
                            autofocus>
                    </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-3">
                        <label for="complemento">Complemento</label>
                        <input id="complemento" type="text"
                            class="form-control-rounded form-control"
                            name="complemento" required
                            autofocus>
                    </div>
                    <div class="col-3">
                            <label for="bairro">Bairro *</label>
                            <input id="bairro" type="text"
                                class="form-control-rounded form-control"
                                name="bairro" required
                                autofocus>
                        </div>
                    <div class="col-3">
                            <label for="cidade">Cidade *</label>
                            <input id="cidade" type="text"
                                class="form-control-rounded form-control"
                                name="cidade" required
                                autofocus>
                        </div>
                        <div class="col-3">
                        <label for="estado">Estado *</label>
                            <input id="estado" type="text"
                                class="form-control-rounded form-control"
                                name="estado" required
                                autofocus>
                        </div>
                            <div class="col-6">
                                <label for="complemento">Segmento</label>
                                <input id="segmento" type="text"
                                    class="form-control-rounded form-control"
                                    name="complemento" required
                                    autofocus>
                            </div>
                    </div>
                    <div class="form-group text-right">
                        <button type="button" id="gravar" class="btn btn-primary btn-rounded mt-3">Cadastrar</button>
                    </div>
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
<script src="{{asset('assets/js/jquery-confirm.js')}}"></script>
<script src="{{asset('assets/js/sistema.js')}}"></script>
<script src="{{asset('assets/js/empresa/empresa.js')}}"></script>
@endsection
