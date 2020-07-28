@extends('layouts.master')
@section('main-content')
<div class="breadcrumb">
    <h1>Novo Projeto</h1>
    <ul>
        <li><a href="">Dashboard</a></li>
        <li>Novo Projeto</li>
    </ul>
</div>

<div class="separator-breadcrumb border-top"></div>
<div class="card ">
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <form method="POST" action="#">
                    <div class="form-group row">
                        <div class="col-12 col-md-4">
                            <label for="nomeprojeto">Nome do Projeto</label>
                            <input id="nome" type="text"
                                class="form-control-rounded form-control"
                                name="nome"  required
                                autofocus>
                        </div>
                        <div class="col-12 col-md-4">
                            <label for="descricao">Descrição</label>
                            <input id="descricao" type="text"
                                class="form-control-rounded form-control"
                                name="descricao"  required
                                autofocus>
                        </div>
                        <div class="col-12 col-md-4">
                            <label for="cnpj">Status</label>
                            <select name="status" class="form-control-rounded form-control" id="status">
                                <option value="0">Em andamento</option>
                                <option value="1">Concluído</option>
                                <option value="2">Pausado</option>
                                <option value="3">Cancelado</option>
                                <option value="4">Excluido</option>
                            </select>
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
                    </div>
                    <div class="form-group row">
						 <div class="col-12 col-md-4">
                            <label for="cnpj">Etapa</label>
                            <select name="status" class="form-control-rounded form-control" id="etapa">
                                <option value="0">Briefing</option>
                                <option value="1">Projeto</option>
                                <option value="2">Planejamento</option>
                                <option value="3">Obra</option>
                                <option value="4">Produção</option>
                            </select>
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
<script src="{{asset('assets/js/projeto/projeto.js')}}"></script>
@endsection
