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
        @include('projetos.sidebar-projeto',[$sobre = '', $cronograma = '',  $orcamento = '', $financeiro2 = '',  $reuniao = '',  $notificacao = 'active',  $projetos = '',  $usuarios2 = ''])
        <div class="col-12 col-md-10">
            <div class="card card-padrao">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <h2>Notificações</h2>
                        </div>
                        <div class="col-12 col-md-6 text-right">
                        <?php if($_SESSION['tipo'] == 0 || $_SESSION['tipo'] == 2): ?>
                            <a href="notificacoes/novo" class="btn btn-primary">Nova Notificação</a>
                        <?php endif; ?>
                        </div>
                            <div class="col-12 col-md-12">
                                <div id="accordion">
                                 <?php $x = 0; foreach ($detalhes['itens'] as $itens): ?>
                                    <div class="card">
                                         <div class="card-header" id="heading<?php echo($itens[0]['id_categoria']);?>">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapse<?php echo($itens[0]['id_categoria']);?>" aria-expanded="true" aria-controls="collapse<?php echo($itens[0]['id_categoria']);?>">
                                                <?php echo($itens[0]['nome']);?>
                                                </button>
                                            </h5>
                                        </div>
                                        <div id="collapse<?php echo($itens[0]['id_categoria']);?>"
                                        <?php  if($x == 0){ echo 'class="collapse show"'; }else {echo 'class="collapsed collapse"';}  ?>
                                        aria-labelledby="heading<?php echo($itens[0]['id_categoria']);?>" data-parent="#accordion">
                                            <div class="card-body">
                                            <div class="table-responsive tabela-custom">
                                                    <table class="display table table-striped table-bordered" id="categoria1" style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th>Descrição</th>
                                                                <th>Prancha</th>
                                                                <th>Documento</th>
                                                                <th>Escala</th>
                                                                <th>Download</th>
                                                                <th>Link</th>
                                                                <th>Previsto</th>
                                                                <th>Status</th>
                                                                 <th>Ações</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php foreach ($itens as $value):?>

                                                        <?php

                                                            $status = '';

                                                        	 if($value['status'] == 0)
                                                        	 {
                                                        	     $status = 'Pendente';
                                                        	 }
                                                        	 elseif($value['status'] == 1)
                                                        	 {
                                                        	     $status = 'Aprovado';
                                                        	 }
                                                        	 elseif($value['status'] == 2)
                                                        	 {
                                                        	     $status = 'Reprovado';
                                                        	 }
                                                        	 elseif($value['status'] == 3)
                                                        	 {
                                                        	     $status = 'Excluido';
                                                        	 }
                                                       ?>

                                                            <tr>
                                                                <td><?php echo($value['descricao']);?></td>
                                                               <td><?php echo($value['prancha']);?></td>
                                                                <td><?php echo($value['documento']);?></td>
                                                                <td><?php echo($value['escala']);?></td>
                                                                <td><?php if($value['arquivo'] != ''): ?><a href="<?php echo($value['arquivo']);?>" target="_blank">Download</a><?php endif; ?></td>
                                                                <td><?php if($value['link'] != ''): ?><a href="<?php echo($value['link']);?>" target="_blank">Link</a><?php endif; ?></td>
                                                                <td><?php echo($value['previsto']);?></td>
                                                               <td><?php echo($status);?></td>

                                                                <td>
                                                                <a href="{{ url('/projeto/') }}/<?php echo $_SESSION['idprojeto'];  ?>/notificacao/editar/<?php echo($value['id']);?>" class="btn btn-primary">Editar</a>
                                                                <?php if($_SESSION['tipo'] == 0 || $_SESSION['tipo'] == 2): ?> <a href="#" onclick="ExcluirNotificacao(<?php echo($value['id']);?>)" class="btn btn-outline-danger">Excluir</a><?php endif; ?>
                                                                </td>

                                                            </tr>
                                                             <?php endforeach; ?>
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th>Descrição</th>
                                                                <th>Prancha</th>
                                                                <th>Documento</th>
                                                                <th>Escala</th>
                                                                <th>Download</th>
                                                                <th>Link</th>
                                                                <th>Previsto</th>
                                                                <th>Status</th>
                                                                <th>Ações</th>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                     <?php $x++; endforeach; ?>
                                </div>
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
<script src="{{asset('assets/js/anexo/anexo.js')}}"></script>
<script src="{{asset('assets/js/projeto/descricao.js')}}"></script>
<script src="{{asset('assets/js/notificacoes/notificacoes.js')}}"></script>
@endsection
