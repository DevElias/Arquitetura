@extends('layouts.master')
@section('main-content')
<div class="breadcrumb">
    <h1><?php echo($detalhes['projeto']->nome);?></h1>
    <ul>
        <li><a href="">Dashboard</a></li>
        <li><?php echo($detalhes['projeto']->nome);?></li>
    </ul>
</div>

<div class="separator-breadcrumb border-top"></div>
  <div class="row">
    @include('projetos.sidebar-projeto', [$sobre = 'active', $cronograma = '',  $orcamento = '', $financeiro2 = '',  $reuniao = '',  $notificacao = '',  $projetos = '',  $usuarios2 = ''])
    <div class="col-12 col-md-10">
        <div class="card card-padrao">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-10">
                        <h4>
                        <span class="icon-projeto-list icon-descricao"></span>
                        <strong>Status</strong></h4>
                        <div class="row">
                            <?php

                            $briefing      = $detalhes['projeto']->etapa == 0 ? '<div class="col-6 col-md-2 text-center seta-direita etapaativa"> <span class="icon-status-list icon-briefing"></span> <strong> Briefing </strong></div>' :  '<div class="col-6 col-md-2 seta-direita text-center" id="0"> <span class="icon-status-list icon-briefing"></span> Briefing </div>';
                            $Projeto       = $detalhes['projeto']->etapa == 1 ? '<div class="col-6 col-md-2 text-center seta-direita etapaativa" ><span class="icon-status-list icon-projeto"></span> <strong> Projeto </strong></div>'  :  '<div class="col-6 col-md-2 text-center seta-direita" id="0"><span class="icon-status-list icon-projeto"></span> Projeto </div>';
                            $Planejamento  = $detalhes['projeto']->etapa == 2 ? '<div class="col-6 col-md-2 text-center seta-direita etapaativa"><span class="icon-status-list icon-planejamento"></span>  <strong> Planejamento </strong></div>'  :  '<div class="col-6 col-md-2 text-center seta-direita" id="0"><span class="icon-status-list icon-planejamento"></span> Planejamento </div>';
                            $Obra          = $detalhes['projeto']->etapa == 3 ? '<div class="col-6 col-md-2 text-center seta-direita etapaativa"  ><span class="icon-status-list icon-obra"></span> <strong> Obra </strong></div>'  :  '<div class="col-6 col-md-2 text-center seta-direita" id="0"><span class="icon-status-list icon-obra"></span> Obra </div>';
                            $Producao      = $detalhes['projeto']->etapa == 4 ? '<div class="col-6 col-md-2 text-center etapaativa" ><span class="icon-status-list icon-obra"></span><strong> Produção </strong></div>'  :  '<div class="col-6 col-md-2 text-center" id="0"><span class="icon-status-list icon-producao"></span> Produção </div>';

                            ?>
                        	<?php echo($briefing);?>
                            <?php echo($Projeto);?>
                            <?php echo($Planejamento);?>
                            <?php echo($Obra);?>
                            <?php echo($Producao);?>
                        </div>
                    </div>
                    <?php if($_SESSION['tipo'] == 0 || $_SESSION['tipo'] == 2): ?>
                    <div class="col-12 col-md-2 text-right">
                        <a href="/atualizar/<?php echo($detalhes['projeto']->id);?>/projeto" class="btn btn-primary">Editar</a>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="row">
                    <div class="col-12">
                        <h4><span class="icon-projeto-list icon-descricao"></span> <strong>Descrição</strong></h4>
                        <p><?php echo($detalhes['projeto']->descricao);?></p>
                    </div>
                    <div class="col-12 col-md-6">
                        <h4><strong>Endereço</strong></h4>
                        <p><?php echo($detalhes['projeto']->endereco);?>, <?php echo($detalhes['projeto']->numero);?> <br> <?php echo($detalhes['projeto']->bairro);?> <br><?php echo($detalhes['projeto']->cep);?><br><?php echo($detalhes['projeto']->complemento);?></p>
                    </div>
                     <?php foreach ($detalhes['usuarios'] as $value):?>
                        <div class="col-12">
                            <h4><strong><?php echo($value->nome);?></strong></h4>
                            <?php if($value->telefone): ?><p>Tel: <span data-mask="(00) 0000-00000"> <?php echo($value->telefone);?></span><br><?php endif; ?><?php if($value->cpf): ?> Cpf: <span data-mask="000.000.000-00"><?php echo($value->cpf);?></span><?php endif; ?></p>
                        </div>
                     <?php endforeach; ?>
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
<script src="{{asset('assets/js/empresa/empresa.js')}}"></script>
@endsection
