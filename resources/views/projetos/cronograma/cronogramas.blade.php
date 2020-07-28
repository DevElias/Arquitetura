@extends('layouts.master')
@section('main-content')
<div class="breadcrumb">
    <h1 id="nomeprojeto"></h1>
    <ul>
        <li><a href="">Dashboard</a></li>
        <li>Novo Cronograma</li>
    </ul>
</div>

<div class="separator-breadcrumb border-top"></div>
    <div class="row">
        @include('projetos.sidebar-projeto' ,[$sobre = '', $cronograma = 'active',  $orcamento = '', $financeiro2 = '',  $reuniao = '',  $notificacao = '',  $projetos = '',  $usuarios2 = ''])
        <div class="col-12 col-md-10">
            <div class="card card-padrao">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <h2>Cronogramas</h2>
                        </div>
                        <div class="col-12 col-md-6 text-right">
                        <?php if($_SESSION['tipo'] == 0): ?>
                            <button class="btn btn-primary"  data-toggle="modal" data-target="#novaCronograma">Novo Cronograma</button>
                            <?php endif; ?>
                        </div>
                         <?php foreach ($cronogramas as $cronograma): ?>
                            <div class="col-12 col-md-3">
                                	<div class="card card-custom mb-4">
                                        <a href="cronogramas/<?php echo($cronograma->id);?>/detalhes" class="card-body text-center">
                                            <p>Cronograma</p>
                                            <h2><?php echo($cronograma->nome);?></h2>
                                            <?php

                                            	 $html = '';

                                            	 if($cronograma->status == 0)
                                            	 {
                                            	     $html = '<span class="btn btn-warning m-1">Status: Em andamento</span>';
                                            	 }
                                            	 elseif($cronograma->status == 1)
                                            	 {
                                            	     $html = '<span class="btn btn-success m-1">Status: Concluido</span>';
                                            	 }
                                            	 elseif($cronograma->status == 2)
                                            	 {
                                            	     $html = '<span class="btn btn-success m-1">Status: Pausado</span>';
                                            	 }
                                            	 elseif($cronograma->status == 3)
                                            	 {
                                            	     $html = '<span class="btn btn-success m-1">Status: Cancelado</span>';
                                            	 }
                                            	 elseif($cronograma->status == 4)
                                            	 {
                                            	     $html = '<span class="btn btn-success m-1">Status: Excluido</span>';
                                            	 }

                                            	 echo($html);
                                           ?>
                                        </a>
                                        <?php if($_SESSION['tipo'] == 0): ?>
                                        <p class="text-center">
                                        <button class="btn btn-primary" onclick="EditarCronograma(<?php echo($cronograma->id);?>);"  data-toggle="modal" data-target="#editCronograma">Editar</button>
                                        </p>
                                        <?php endif; ?>
                                    </div>
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
                        <input id="idcronograma" type="hidden"
                            class="form-control-rounded form-control"
                            name="idcronograma" value="">
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

<!-- Modal -->
<div class="modal fade" id="editCronograma" tabindex="-1" role="dialog" aria-labelledby="editCronogramaLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="novaCronogramaLabel">Editar Cronograma</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" id="formularioedit">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="editcronograma">Nome do Cronograma</label>
                        <input id="editcronograma" type="text"
                            class="form-control-rounded form-control"
                            name="editcronograma">
                    </div>
                    <div class="form-group row">
                        <div class="col-12">
                            <label for="status">Selecione o Status</label>
                                <select name="editstatus" class="form-control-rounded form-control" id="editstatus">
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
                            <div class="form-group">
                        <input id="idcronogramaedit" type="hidden"
                            class="form-control-rounded form-control"
                            name="idcronogramaedit">
                    </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="button" id="editargravarcronograma" class="btn btn-primary">Atualizar Cronograma</button>
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
