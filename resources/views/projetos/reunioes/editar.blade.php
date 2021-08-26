@extends('layouts.master')
@section('main-content')
<div class="breadcrumb">
    <h1 id="nomeprojeto"></h1>
    <ul>
        <li><a href="">Dashboard</a></li>
        <li>Reuniões</li>
    </ul>
</div>

<div class="separator-breadcrumb border-top"></div>
  <div class="row">
    @include('projetos.sidebar-projeto',[$sobre = '', $cronograma = '',  $orcamento = '', $financeiro2 = '',  $reuniao = 'active',  $notificacao = '',  $projetos = '',  $usuarios2 = ''])
    <div class="col-12 col-md-10">
        <div class="card card-padrao">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <h2>Editar Reunião</h2>
                    </div>
                    <div class="col-12">
                        <form action="#" id="formularioedicao">
                            <input type="hidden" class="form-control-rounded form-control" name="idprojeto" id="idprojeto" value="<?php echo($detalhes['reuniao']->id_projeto);?>">
                            <input type="hidden" class="form-control-rounded form-control" name="idreuniao" id="idreuniao" value="<?php echo($detalhes['reuniao']->id);?>">
                        <div class="form-group row">
                        <div class="col-12 col-md-6">
                                <label for="titulo">Título da Reunião</label>
                                <input type="text" class="form-control-rounded form-control" name="titulo" id="titulo" value="<?php echo($detalhes['reuniao']->titulo);?>">
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="categoria">Selecione a Categoria</label>
                                    <select class="form-control-rounded form-control" name="categoria" id="categoria">
                                      <?php foreach ($detalhes['categorias'] as $categoria): ?>
										 	<?php if($detalhes['reuniao']->id_categoria == $categoria->id){?>
                                        		<option value="<?php echo($categoria->id);?>" selected><?php echo($categoria->nome);?></option>
                                        	<?php }else{?>
                                        		<option value="<?php echo($categoria->id);?>"><?php echo($categoria->nome);?></option>
                                        		<?php }?>
                                    	<?php endforeach; ?>
                                    </select>
                            </div>
                        </div>
                            <div class="form-group row">
                                <div class="col-12 col-md-2">
                                    <label for="descricao">Data</label>
                                    <input type="text" class="form-control-rounded form-control" name="data" id="data" value="<?php echo($detalhes['reuniao']->data);?>">
                                </div>
                                <div class="col-12 col-md-2">
                                    <label for="horainicio">Hora Início</label>
                                    <input type="text" class="form-control-rounded form-control" name="horainicio" id="horainicio" value="<?php echo($detalhes['reuniao']->hora_inicio);?>">
                                </div>
                                <div class="col-12 col-md-2">
                                    <label for="horafim">Hora Fim</label>
                                    <input type="text" class="form-control-rounded form-control" name="horafim" id="horafim" value="<?php echo($detalhes['reuniao']->hora_fim);?>">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="local">Localização</label>
                                    <input type="text" class="form-control-rounded form-control" name="local" value="<?php echo($detalhes['reuniao']->localizacao);?>" />
                                </div>
                                <div class="col-12">
                                        <label for="executor">Descrição</label>
                                        <textarea  rows="3"
                                            class="form-control-rounded form-control"
                                            name="descricao" ide="descricao"  required
                                            ><?php echo($detalhes['reuniao']->descricao);?></textarea>
                                    </div>

                                <div class="col-12">
                                    <h2 style="padding-top:20px;">Convidar Usuários</h2>
                                </div>
                                <div class="col-12">
                                <?php foreach ($detalhes['usuarios'] as $value):?>
                                	<?php if($value->StatusParticipante == 'S'){?>
                                		 <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" checked name="chk" id="<?php echo($value->id);?>" value="<?php echo($value->id);?>">
                                            <label class="form-check-label" for="inlineCheckbox1"><?php echo($value->nome);?></label>
                                        </div>
                                	<?php }else{?>
                                			<div class="form-check form-check-inline">
                                    			<input class="form-check-input" type="checkbox" name="chk" id="<?php echo($value->id);?>" value="<?php echo($value->id);?>">
                                                <label class="form-check-label" for="inlineCheckbox1"><?php echo($value->nome);?></label>
                                            </div>
                                		<?php }?>
                                 <?php endforeach; ?>
                                </div>

                                    <div class="col-12">
                                        <label for="categoria">Texto Adicional ao e-mail de convite a reunião:</label>
                                            <input type="text"
                                            class="form-control-rounded form-control"
                                            name="textoadicional"
                                            required value="<?php echo($detalhes['reuniao']->texto_adicional);?>">
                                    </div>
                            </div>
                            <div class="row">
                                <div class="col-12 text-right">
                                    <a href="{{ url('/projeto/') }}/<?php echo $_SESSION['idprojeto'];  ?>/reunioes/detalhes/<?php echo($detalhes['reuniao']->id);?>" class="btn btn-secondary" id="excluir">Voltar</a>
                                    <button type="button" class="btn btn-primary" id="editargravar">Atualizar Reunião</button>
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
<script src="{{asset('assets/js/reuniao/reuniao.js')}}"></script>
@endsection
