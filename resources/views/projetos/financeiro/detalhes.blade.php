@extends('layouts.master')
@section('main-content')
<div class="breadcrumb">
    <h1 id="nomeprojeto"></h1>
    <ul>
        <li><a href="">Dashboard</a></li>
        <li>Detalhes Financeiro</li>
    </ul>
</div>

<div class="separator-breadcrumb border-top"></div>
    <div class="row">
        @include('projetos.sidebar-projeto',[$sobre = '', $cronograma = '',  $orcamento = '', $financeiro2 = 'active',  $reuniao = '',  $notificacao = '',  $projetos = '',  $usuarios2 = ''])
        <div class="col-12 col-md-10">
            <div class="card card-padrao">
                <div class="card-body">
                    <div class="row">
                        <?php foreach ($pagamentos['pagamento'] as $pagamento): ?>
                        <div class="col-12 text-right">
                        <a href="{{ url('/projeto/') }}/<?php echo $_SESSION['idprojeto'];  ?>/financeiro/agenda" class="btn btn-outline-primary">Voltar Agenda</a>
                            <a href="{{ url('/projeto/') }}/<?php echo $_SESSION['idprojeto'];  ?>/financeiro/editar/<?php echo($pagamento->id);?>" class="btn btn-primary">Editar Pagamento</a>
                        </div>

                            <div class="col-12">
                               <h2> <?php echo($pagamento->descricao);?></h2>
                            </div>
                            <div class="col-12 col-md-4">
                                <h3>R$ <?php echo($pagamento->valor);?></h3>
                            </div>
                            <div class="col-12 col-md-4">
                                <h3>Dia do Pagamento: <?php echo($pagamento->dia_pagamento);?></h3>
                            </div>
                            <div class="col-12 col-md-4">
                                <h3>Parcelas: <?php echo($pagamento->parcelas);?> de <?php echo($pagamento->replicar);?></h3>
                            </div>
                            <div class="col-12 col-md-4">
                                <h3>Categoria: <?php echo($pagamento->categoria);?></h3>
                            </div>
                            <div class="col-12 col-md-4">
                                <h3>Status: <?php
                                    $html = '';

                                    if($pagamento->status == 0)
                                    {
                                        $html = '<span class="btn btn-warning m-1"> Em aberto</span>';
                                    }
                                    elseif($pagamento->status == 1)
                                    {
                                        $html = '<span class="btn btn-success m-1">Atrasado</span>';
                                    }
                                    elseif($pagamento->status == 2)
                                    {
                                        $html = '<span class="btn btn-success m-1">Em análise</span>';
                                    }
                                    elseif($pagamento->status == 3)
                                    {
                                        $html = '<span class="btn btn-success m-1">Pago</span>';
                                    }
                                    elseif($pagamento->status == 4)
                                    {
                                        $html = '<span class="btn btn-success m-1">Excluido</span>';
                                    }

                                    echo($html);
                                    ?></h3>
                            </div>
                            <?php if($pagamento->arquivo): ?>
                            <div class="col-12">
                                <h3>Arquivo:</h3>
                                <p> <a href=" <?php echo($pagamento->arquivo);?>" class="btn btn-default btn-primary" target="_blank">Link</a></p>
                            </div>
                            <?php endif; ?>
                            <div class="col-12">
                                <h3>Detalhes:</h3>
                                <p>  <?php echo($pagamento->detalhe);?></p>
                            </div>
                        <?php endforeach; ?>
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
                        <label for="cronograma">Nome do Cronograma</label>
                        <input id="cronograma" type="text"
                            class="form-control-rounded form-control"
                            name="cronograma"  required
                            autofocus>
                    </div>
                    <div class="form-group row">
                        <div class="col-12">
                            <label for="status">Selecione o Status</label>
                                <select name="status" class="form-control-rounded form-control" id="status">
                                    <option value="0">Em andamento</option>
                                    <option value="1">Concluído</option>
                                    <option value="2">Pausado</option>
                                    <option value="3">Cancelado</option>
                                    <option value="4">Excluido</option>
                            	</select>
                        </div>
                        <input id="idprojeto" type="hidden"
                            class="form-control-rounded form-control"
                            name="idprojeto">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="button" id="gravar" class="btn btn-primary">Criar Cronograma</button>
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
<script src="{{asset('assets/js/cronograma/cronograma.js')}}"></script>
<script src="{{asset('assets/js/projeto/descricao.js')}}"></script>
@endsection
