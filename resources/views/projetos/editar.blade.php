@extends('layouts.master')
@section('main-content')
<div class="breadcrumb">
    <h1>Editar Projeto</h1>
    <ul>
        <li><a href="">Dashboard</a></li>
        <li>Editar Projeto</li>
    </ul>
</div>

<div class="separator-breadcrumb border-top"></div>
<div class="card ">
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <form method="POST" action="#" id="formularioedicao">
                    <div class="form-group row">
                        <div class="col-12 col-md-4">
                            <label for="nomeprojeto">Nome do Projeto</label>
                            <input id="nome" type="text"
                                class="form-control-rounded form-control" value="<?php echo($detalhes['projeto']->nome);?>"
                                name="nome">
                        </div>
                        <div class="col-12 col-md-4">
                            <label for="descricao">Descrição</label>
                            <input id="descricao" type="text"
                                class="form-control-rounded form-control"
                                name="descricao"  value="<?php echo($detalhes['projeto']->descricao);?>">
                        </div>
                        <div class="col-12 col-md-4">
                        
                         <?php 
						 
						 $andamento = '';
						 $concluido = '';
						 $pausado   = '';
						 $cancelado = '';
						 $excluido  = '';
						 
						 if($detalhes['projeto']->status == 0)
						 {
						     $andamento = 'selected';
						 }
						 elseif($detalhes['projeto']->status == 1)
						 {
						     $concluido = 'selected';
						 }
						 elseif($detalhes['projeto']->status == 2)
						 {
						     $pausado = 'selected';
						 }
						 elseif($detalhes['projeto']->status == 3)
						 {
						     $cancelado = 'selected';
						 }
						 elseif($detalhes['projeto']->status == 4)
						 {
						     $excluido = 'selected';
						 }
					 ?>
                            <label for="cnpj">Status</label>
                            <select name="status" class="form-control-rounded form-control" id="status">
                                <option value="0" <?php echo($andamento);?>>Em andamento</option>
                                <option value="1" <?php echo($concluido);?>>Concluído</option>
                                <option value="2" <?php echo($pausado);?>>Pausado</option>
                                <option value="3" <?php echo($cancelado);?>>Cancelado</option>
                                <option value="4" <?php echo($excluido);?>>Excluido</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                    <div class="col-3">
                        <label for="cep">CEP *</label>
                        <input id="cep" type="text"
                            class="form-control-rounded form-control"
                            name="cep" value="<?php echo($detalhes['projeto']->cep);?>">
                    </div>
                    <div class="col-6">
                        <label for="endereco">Endereço *</label>
                        <input id="endereco" type="text"
                            class="form-control-rounded form-control"
                            name="endereco" value="<?php echo($detalhes['projeto']->endereco);?>">
                    </div>
                    <div class="col-3">
                        <label for="numero">Numero *</label>
                        <input id="numero" type="text"
                            class="form-control-rounded form-control"
                            name="numero" value="<?php echo($detalhes['projeto']->numero);?>">
                    </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-3">
                        <label for="complemento">Complemento</label>
                        <input id="complemento" type="text"
                            class="form-control-rounded form-control"
                            name="complemento" value="<?php echo($detalhes['projeto']->complemento);?>">
                    </div>
                    <div class="col-3">
                            <label for="bairro">Bairro *</label>
                            <input id="bairro" type="text"
                                class="form-control-rounded form-control"
                                name="bairro" value="<?php echo($detalhes['projeto']->bairro);?>">
                        </div>
                    <div class="col-3">
                            <label for="cidade">Cidade *</label>
                            <input id="cidade" type="text"
                                class="form-control-rounded form-control"
                                name="cidade" value="<?php echo($detalhes['projeto']->cidade);?>">
                        </div>
                        <div class="col-3">
                        <label for="estado">Estado *</label>
                            <input id="estado" type="text"
                                class="form-control-rounded form-control"
                                name="estado" value="<?php echo($detalhes['projeto']->estado);?>">
                                
                                <input id="idprojeto" type="hidden"
                                class="form-control-rounded form-control"
                                name="idprojeto" value="<?php echo($detalhes['projeto']->id);?>">
                        </div>
                    </div>
                    <div class="form-group row">
						 <div class="col-12 col-md-4">
						 
						 <?php 
						 
						 $briefing      = '';
						 $projetostatus = '';
						 $planejamento  = '';
						 $obra          = '';
						 $producao      = '';
						 
						 if($detalhes['projeto']->etapa == 0)
						 {
						     $briefing = 'selected';
						 }
						 elseif($detalhes['projeto']->etapa == 1)
						 {
						     $projetostatus = 'selected';
						 }
						 elseif($detalhes['projeto']->etapa == 2)
						 {
						     $planejamento = 'selected';
						 }
						 elseif($detalhes['projeto']->etapa == 3)
						 {
						     $obra = 'selected';
						 }
						 elseif($detalhes['projeto']->etapa == 4)
						 {
						     $producao = 'selected';
						 }
						 
						 ?>
                            <label for="etapa">Etapa</label>
                            <select name="etapa" class="form-control-rounded form-control" id="etapa">
                                <option value="0" <?php echo($briefing);?>>Briefing</option>
                                <option value="1" <?php echo($projetostatus);?>>Projeto</option>
                                <option value="2" <?php echo($planejamento);?>>Planejamento</option>
                                <option value="3" <?php echo($obra);?>>Obra</option>
                                <option value="4" <?php echo($producao);?>>Produção</option>
                            </select>
                        </div>                
                    </div>
                    <div class="form-group text-right">
                        <button type="button" id="editargravar" class="btn btn-primary btn-rounded mt-3">Atualizar</button>
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
