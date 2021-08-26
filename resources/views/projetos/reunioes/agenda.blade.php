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
                <div class="col-12 col-md-6">
                        <h2>Reuniões - Agenda</h2>
                    </div>
                    <div class="col-12 col-md-6 text-right padding-bottom20">
                    <?php if($_SESSION['tipo'] == 0 || $_SESSION['tipo'] == 2): ?><a class="btn btn-primary" href="reunioes/novo/">Adicionar Reunião</a><?php endif; ?>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="card mb-4 o-hidden">
                            <div class="card-body">
                                <div id="calendar"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="card">
                            <table class="display table" id="categoria1" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Data</th>
                                        <th>Local</th>
                                        <th>Hora</th>
                                        <th>Detalhes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($reunioes as $value):?>
                                    <tr>
                                        <td><?php echo($value->data);?></td>
                                        <td><?php echo($value->localizacao);?></td>
                                        <td><?php echo($value->hora_inicio);?> às <?php echo($value->hora_fim);?></td>
                                        <td>
                                        <a href="reunioes/detalhes/<?php echo($value->id);?>" class="btn btn-outline-primary">Detalhes</a>
                                        </td>
                                <?php endforeach; ?>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Data</th>
                                        <th>Local</th>
                                        <th>Hora</th>
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

@endsection

@section('page-js')
<script src="{{asset('assets/js/vendor/echarts.min.js')}}"></script>
<script src="{{asset('assets/js/es5/echart.options.min.js')}}"></script>
<script src="{{asset('assets/js/es5/dashboard.v1.script.js')}}"></script>
<script src="{{asset('assets/js/jquery.mask.min.js')}}"></script>
<script src="{{asset('assets/js/jquery-confirm.js')}}"></script>
<script src="{{asset('assets/js/sistema.js')}}"></script>
<script src="{{asset('assets/js/projeto/descricao.js')}}"></script>
<script src="{{asset('assets/js/vendor/calendar/moment.min.js')}}"></script>
<script src="{{asset('assets/js/vendor/calendar/fullcalendar.min.js')}}"></script>
<script src="{{asset('assets/js/calendar.script.js')}}"></script>
<link rel="stylesheet" href="{{asset('assets/styles/css/plugins/calendar/fullcalendar.min.css')}}" />
@endsection
