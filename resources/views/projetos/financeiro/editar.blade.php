@extends('layouts.master')
@section('main-content')
<div class="breadcrumb">
    <h1 id="nomeprojeto"></h1>
    <ul>
        <li><a href="">Dashboard</a></li>
        <li>Financeiro</li>
    </ul>
</div>

<div class="separator-breadcrumb border-top"></div>
  <div class="row">
    @include('projetos.sidebar-projeto',[$sobre = '', $cronograma = '',  $orcamento = '', $financeiro2 = 'active',  $reuniao = '',  $notificacao = '',  $projetos = '',  $usuarios2 = ''])
    <div class="col-12 col-md-10">
        <div class="card card-padrao">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <h2>Editar Pagamento</h2>
                    </div>
                    <div class="col-12">
                        <form action="#" id="formularioedicao">
                        <div class="form-group row">
                            <div class="col-12 col-md-4">
                                <label for="descricao">Descrição</label>
                                <input type="text" class="form-control-rounded form-control" name="descricao" disabled value="<?php echo($pagamento['pagamento']->descricao);?>">
                            </div>
                            <div class="col-12 col-md-4">
                                <label for="categoria">Selecione a Categoria</label>
                                    <select class="form-control-rounded form-control" name="categoria" id="categoria">
										 <?php foreach ($pagamento['categorias'] as $categoria): ?>
										 	<?php if($pagamento['pagamento']->id_categoria == $categoria->id){?>
                                        		<option value="<?php echo($categoria->id);?>" selected><?php echo($categoria->nome);?></option>
                                        	<?php }else{?>
                                        		<option value="<?php echo($categoria->id);?>"><?php echo($categoria->nome);?></option>
                                        		<?php }?>
                                    	<?php endforeach; ?>
                                    </select>
                            </div>
                            <div class="col-12 col-md-4">
                                <label for="data">Dia do Pagamento</label>
                                <input type="text" class="form-control-rounded form-control" name="data" id="data" value="<?php echo($pagamento['pagamento']->dia_pagamento);?>">
                            </div>
                        </div>
                            <div class="form-group row">
                                <div class="col-6 col-md-3">
                                        <label for="parcelas">Número de Parcelas</label>
                                        <input type="text" disabled
                                            class="form-control-rounded form-control"
                                            name="parcelas" id="parcelas" value="<?php echo($pagamento['pagamento']->parcelas);?>"
                                            required>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label for="comeco">Replicar Pagamento</label>
                                        <select class="form-control-rounded form-control" name="replicar" id="replicar" disabled>

                                        <?php

                                        $replicar0 = '';
                                        $replicar1 = '';
                                        $replicar2 = '';
                                        $replicar3 = '';

                                        $pagamento['pagamento']->replicar == 0 ? $replicar0 = 'selected' :  '';
                                        $pagamento['pagamento']->replicar == 1 ? $replicar1 = 'selected' :  '';
                                        $pagamento['pagamento']->replicar == 2 ? $replicar2 = 'selected' :  '';
                                        $pagamento['pagamento']->replicar == 3 ? $replicar3 = 'selected' :  '';

                                        ?>

                                        <option value="0" <?php echo($replicar0);?>>Nenhum</option>
                                        <option value="1" <?php echo($replicar1);?>>Semanal</option>
                                        <option value="2" <?php echo($replicar2);?>>Quinzenal</option>
                                        <option value="3" <?php echo($replicar3);?>>Mensal</option>
                                        </select>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <input type="file" class="custom-file-input" id="customFile" >
                                        <label class="custom-file-label form-control-rounded form-control" for="customFile">Escolha o Arquivo</label>
                                        <span id="msgupload"></span>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label for="executor">Status</label>
                                        <select name="status" class="form-control-rounded form-control" id="status">
                                        <?php

                                        $status0 = '';
                                        $status1 = '';
                                        $status2 = '';
                                        $status3 = '';
                                        $status4 = '';

                                        $pagamento['pagamento']->status == 0 ? $status0 = 'selected' :  '';
                                        $pagamento['pagamento']->status == 1 ? $status1 = 'selected' :  '';
                                        $pagamento['pagamento']->status == 2 ? $status2 = 'selected' :  '';
                                        $pagamento['pagamento']->status == 3 ? $status3 = 'selected' :  '';
                                        $pagamento['pagamento']->status == 4 ? $status4 = 'selected' :  '';

                                        ?>
                                            <option value="0" <?php echo($status0);?>>Em aberto</option>
                                            <option value="1" <?php echo($status1);?>>Atrasado</option>
                                            <option value="2" <?php echo($status2);?>>Em análise</option>
                                            <option value="3" <?php echo($status3);?>>Pago</option>
                                            <option value="4" <?php echo($status4);?>>Excluido</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label for="categoria">Valor da Parcela</label>
                                            <input type="text"
                                            class="form-control-rounded form-control"
                                            name="valor" id="valor" value="<?php echo($pagamento['pagamento']->valor);?>"
                                            <?php if($_SESSION['tipo'] == 1){ echo 'disabled'; } ?>
                                            required>
                                    </div>
                                    <div class="col-12">
                                        <label for="executor">Detalhes</label>
                                        <textarea  rows="3"
                                            class="form-control-rounded form-control"
                                            name="detalhe" ide="detalhe" required
                                            ><?php echo($pagamento['pagamento']->detalhe);?></textarea>
                                            <input type="hidden" class="form-control-rounded form-control" name="idprojeto" id="idprojeto" value="<?php echo($pagamento['pagamento']->id_projeto);?>">
                                            <input type="hidden" class="form-control-rounded form-control" name="idpagamento" id="idpagamento" value="<?php echo($pagamento['pagamento']->id);?>">
                                            <input type="hidden" class="form-control-rounded form-control" name="url" id="url" value="<?php echo($pagamento['pagamento']->arquivo);?>">
                                    </div>
                            </div>
                            <div class="row">
                                <div class="col-12 text-right">
                                <?php if($_SESSION['tipo'] == 0): ?>	<a href="#" onclick="ExcluirPagamento(<?php echo($pagamento['pagamento']->id);?>)" class="btn btn-outline-danger">Excluir</a><?php endif; ?>
                                    <button type="button" class="btn btn-primary" id="editargravar">Atualizar Pagamento</button>
                                </div>
                            </div>

                </form>
                    </div>
                </div>
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
<script src="{{asset('assets/js/projeto/descricao.js')}}"></script>
<script src="{{asset('assets/js/financeiro/financeiro.js')}}"></script>
@endsection
