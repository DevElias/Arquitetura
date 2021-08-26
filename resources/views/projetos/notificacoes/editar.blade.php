@extends('layouts.master')
@section('main-content')
<div class="breadcrumb">
    <h1 id="nomeprojeto"></h1>
    <ul>
        <li><a href="">Dashboard</a></li>
        <li>Documentos</li>
    </ul>
</div>

<div class="separator-breadcrumb border-top"></div>
  <div class="row">
    @include('projetos.sidebar-projeto',[$sobre = '', $cronograma = '',  $orcamento = '', $financeiro2 = '',  $reuniao = '',  $notificacao = '',  $projetos = 'active',  $usuarios2 = ''])
    <div class="col-12 col-md-10">
        <div class="card card-padrao">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <h2>Editar Notificação</h2>
                    </div>
                    <div class="col-12">
                        <form action="#" id="formularioedicao">
                        <div class="form-group row">
                            <div class="col-12 col-md-6">
                                <label for="descricao">Descrição</label>
                                <input type="text" class="form-control-rounded form-control" name="descricao" value="<?php echo($detalhes['notificacoes']->descricao);?>">
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="categoria">Selecione a Categoria</label>
                                     <select class="form-control-rounded form-control" name="categoria" id="categoria">
										 <?php foreach ($detalhes['categorias'] as $categoria): ?>
										 	<?php if($detalhes['notificacoes']->id_categoria == $categoria->id){?>
                                        		<option value="<?php echo($categoria->id);?>" selected><?php echo($categoria->nome);?></option>
                                        	<?php }else{?>
                                        		<option value="<?php echo($categoria->id);?>"><?php echo($categoria->nome);?></option>
                                        		<?php }?>
                                    	<?php endforeach; ?>
                                    </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-12 col-md-6">
                                <label for="documento">Nome do Arquivo</label>
                                <input type="text" class="form-control-rounded form-control" name="documento" value="<?php echo($detalhes['notificacoes']->documento);?>">
                            </div>

                            <div class="col-6 col-md-6">
                                        <input type="file" class="custom-file-input" id="customFile">
                                        <label class="custom-file-label form-control-rounded form-control" for="customFile">Escolha o Arquivo</label>
                                    </div>
                        </div>
                            <div class="form-group row">
                                <div class="col-12 col-md-2">
                                    <label for="data">Prancha</label>
                                    <input type="text" class="form-control-rounded form-control" name="prancha" value="<?php echo($detalhes['notificacoes']->prancha);?>"/>
                                </div>
                                <div class="col-6 col-md-2">
                                        <label for="escala">Escala</label>
                                        <input type="text"
                                            class="form-control-rounded form-control"
                                            name="escala" id="escala" value="<?php echo($detalhes['notificacoes']->escala);?>">
                                    </div>
                                    <div class="col-6 col-md-2">
                                        <label for="executor">Status</label>
                                        <select name="status" class="form-control-rounded form-control" id="status">

                                        <?php

                                        $status0 = '';
                                        $status1 = '';
                                        $status2 = '';
                                        $status3 = '';

                                        $detalhes['notificacoes']->status == 0 ? $status0 = 'selected' :  '';
                                        $detalhes['notificacoes']->status == 1 ? $status1 = 'selected' :  '';
                                        $detalhes['notificacoes']->status == 2 ? $status2 = 'selected' :  '';
                                        $detalhes['notificacoes']->status == 3 ? $status3 = 'selected' :  '';

                                        ?>

                                            <option value="0" <?php echo($status0);?>>Pendente</option>
                                            <option value="1" <?php echo($status1);?>>Aprovado</option>
                                            <option value="2" <?php echo($status2);?>>Reprovado</option>
                                            <option value="3" <?php echo($status3);?>>Excluido</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-2">
                                        <label for="categoria">Previsto</label>
                                            <input type="text"
                                            class="form-control-rounded form-control"
                                            name="previsto" id="previsto" value="<?php echo($detalhes['notificacoes']->previsto);?>">
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label for="link">Link</label>
                                            <input type="text"
                                            class="form-control-rounded form-control"
                                            name="link" id="link" value="<?php echo($detalhes['notificacoes']->link);?>">
                                    </div>
                                    <div class="col-12">
                                        <label for="detalhe">Detalhes</label>
                                        <textarea  rows="3"
                                            class="form-control-rounded form-control"
                                            name="detalhe" id="detalhe"
                                            ><?php echo($detalhes['notificacoes']->detalhe);?></textarea>
                                            <input type="hidden" class="form-control-rounded form-control" name="idprojeto" id="idprojeto">
                                            <input type="hidden" class="form-control-rounded form-control" name="idnotificacao" id="idanexo" value="<?php echo($detalhes['notificacoes']->id);?>">
                                            <input type="hidden" class="form-control-rounded form-control" name="url" id="url" value="<?php echo($detalhes['notificacoes']->arquivo);?>">
                                    </div>
                            </div>
                            <div class="row">
                                <div class="col-12 text-right">
                                    <a href="{{ url('/projeto/') }}/<?php echo $_SESSION['idprojeto'];  ?>/notificacoes" class="btn btn-outline-primary">Voltar Notificações</a>
                                    <button type="button" class="btn btn-primary" id="editargravar">Atualizar Notificação</button>
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
<script src="{{asset('assets/js/notificacoes/notificacoes.js')}}"></script>
@endsection
