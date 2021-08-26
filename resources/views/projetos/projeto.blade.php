@extends('layouts.master')
@section('main-content')
<div class="breadcrumb">
    <h1>Selecione o Projeto para Navegar</h1>
    <ul>
        <li><a href="">Dashboard</a></li>
        <li>Projeto</li>
    </ul>
</div>

<div class="separator-breadcrumb border-top"></div>

    <div class="row">
        <div class="col-12 col-md-8">
            <?php if($_SESSION['tipo'] == 0 || $_SESSION['tipo'] == 2): ?>
            <a href="/projeto/novo" class="btn btn-success btn-lg m-1"><span class="icon-projetos"></span> Novo Projeto</a>
            <?php endif; ?>
        </div>
        <div class="col-12 col-md-4">
            <div class="form-group row">
                <div class="col-12">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control form-control-rounded" id="desc-projeto" placeholder="Buscar Projeto" aria-label="Buscar Empresa" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-raised-success form-control form-control-rounded" id="search" type="button"><i class="search-icon text-muted i-Magnifi-Glass1"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
   <div class="row" id="busca">
    <?php foreach ($projetos as $projeto): ?>
        <div class="col-md-3">
            <div class="card card-custom mb-4">
            	<a href="/projeto/<?php echo($projeto->id);?>/status" class="card-body text-center">
                    <h2 class="mb-3"> <span class="subtitulo-projeto">Projeto</span><br /><?php echo($projeto->nome);?></h2>
                    <p>
                    	 <?php

                        	 $html = '';

                        	 if($projeto->etapa == 0)
                        	 {
                        	     $html = '<span class="btn btn-warning m-1">Status: Briefing</span>';
                        	 }
                        	 elseif($projeto->etapa == 1)
                        	 {
                        	     $html = '<span class="btn btn-success m-1">Status: Projeto</span>';
                        	 }
                        	 elseif($projeto->etapa == 2)
                        	 {
                        	     $html = '<span class="btn btn-success m-1">Status: Planejamento</span>';
                        	 }
                        	 elseif($projeto->etapa == 3)
                        	 {
                        	     $html = '<span class="btn btn-success m-1">Status: Obra</span>';
                        	 }
                        	 elseif($projeto->etapa == 4)
                        	 {
                        	     $html = '<span class="btn btn-success m-1">Status: Produção</span>';
                        	 }

                        	 echo($html);
                       ?>
                    </p>
                    <hr>
                    <p class="endereco-projeto">Endereço: <?php echo($projeto->endereco . ', ' . $projeto->numero . ' - ' . $projeto->cidade);?></p>

                </a>
            </div>
        </div>
      <?php endforeach; ?>
    </div>
@endsection

@section('page-js')
<script src="{{asset('assets/js/vendor/echarts.min.js')}}"></script>
<script src="{{asset('assets/js/es5/echart.options.min.js')}}"></script>
<script src="{{asset('assets/js/jquery.mask.min.js')}}"></script>
<script src="{{asset('assets/js/es5/dashboard.v1.script.js')}}"></script>
<script src="{{asset('assets/js/projeto/projeto.js')}}"></script>
<script src="{{asset('assets/js/sistema.js')}}"></script>
@endsection
