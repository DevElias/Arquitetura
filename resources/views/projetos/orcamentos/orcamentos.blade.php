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
    <div class="row">
        @include('projetos.sidebar-projeto',[$sobre = '', $cronograma = '',  $orcamento = 'active', $financeiro2 = '',  $reuniao = '',  $notificacao = '',  $projetos = '',  $usuarios2 = ''])
        <div class="col-12 col-md-10">
            <div class="card card-padrao">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-3">
                                <div class="card card-custom mb-4">
                                        <a href="orcamentos/listagem/" class="card-body text-center">
                                            <p>Orçamento</p>
                                            <h2>Listagem de Itens</h2>
                                             </a>
                                    </div>
                            </div>
                            <div class="col-12 col-md-3">
                                <div class="card card-custom mb-4">
                                        <a href="orcamentos/produtos/" class="card-body text-center">
                                            <p>Orçamento</p>
                                            <h2>Aprovações Produtos</h2>
                                             </a>
                                    </div>
                            </div>
                            <div class="col-12 col-md-3">
                                <div class="card card-custom mb-4">
                                        <a href="orcamentos/servicos/" class="card-body text-center">
                                            <p>Orçamento</p>
                                            <h2>Aprovações Serviços</h2>
                                             </a>
                                    </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>

<!-- Modal -->
<div class="modal fade" id="novaCronograma" tabindex="-1" role="dialog" aria-labelledby="novaCronogramaLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="novaCronogramaLabel">Novo Cronograma</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="categoria">Nome do Cronograma</label>
                        <input id="categoria" type="text"
                            class="form-control-rounded form-control"
                            name="categoria"  required
                            autofocus>
                    </div>
                    <div class="form-group row">
                        <div class="col-12">
                            <label for="descricao">Selecione o Status</label>
                                <select class="form-control-rounded form-control" name="status" id="status">
                                    <option value="1">Status 1</option>
                                    <option value="2">Status 2</option>
                                </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Criar Cronograma</button>
                </div>
            </form>
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
