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
                <div class="col-12 col-md-6">
                        <h2>Financeiro - Agenda</h2>
                    </div>
                    <div class="col-12 col-md-6 text-right padding-bottom20">
                    <?php if($_SESSION['tipo'] == 0): ?>  <a class="btn btn-primary" href="novo/">Adicionar Pagamento</a><?php endif; ?>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="card mb-4 o-hidden">
                            <div class="card-body">
                                <div id="calendar"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Em aberto</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Pagos</a>
                    </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="card">
                            <table class="display table" id="categoria1" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Dia</th>
                                        <th>Tipo</th>
                                        <th>Valor</th>
                                        <th>Status</th>
                                        <th>Detalhes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                 <?php foreach ($detalhes['financeiro'] as $pagamento): ?>
                                    <tr>
                                        <td><?php echo($pagamento->dia_pagamento);?></td>
                                        <td><?php echo($pagamento->descricao);?></td>
                                        <td><?php echo($pagamento->valor);?></td>
                                        <td>
                                        <?php

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
                                           ?>

                                        </td>
                                        <td>
                                        <a href="detalhes/<?php echo($pagamento->id);?>" class="btn btn-outline-primary">Detalhes</a>
                                        </td>
                                <?php endforeach; ?>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Dia</th>
                                        <th>Pagamento</th>
                                        <th>Valor</th>
                                        <th>Status</th>
                                        <th>Detalhes</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="card">
                            <table class="display table" id="categoria1" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Dia</th>
                                        <th>Tipo</th>
                                        <th>Valor</th>
                                        <th>Status</th>
                                        <th>Detalhes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                 <?php foreach ($detalhes['pagos'] as $pagamento): ?>
                                    <tr>
                                        <td><?php echo($pagamento->dia_pagamento);?></td>
                                        <td><?php echo($pagamento->descricao);?></td>
                                        <td><?php echo($pagamento->valor);?></td>
                                        <td>
                                        <?php

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
                                           ?>

                                        </td>
                                        <td>
                                        <a href="detalhes/<?php echo($pagamento->id);?>" class="btn btn-outline-primary">Detalhes</a>
                                        </td>
                                <?php endforeach; ?>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Dia</th>
                                        <th>Pagamento</th>
                                        <th>Valor</th>
                                        <th>Status</th>
                                        <th>Detalhes</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
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
<script src="{{asset('assets/js/projeto/descricao.js')}}"></script>
<script src="{{asset('assets/js/calendar/moment.min.js')}}"></script>
<script src="{{asset('assets/js/calendar/fullcalendar.min.js')}}"></script>
<script src="{{asset('assets/js/calendar.script.js')}}"></script>
<script src="{{asset('assets/js/calendar/locale-all.js')}}"></script>
<link rel="stylesheet" href="{{asset('assets/styles/css/plugins/calendar/fullcalendar.min.css')}}" />

@endsection
