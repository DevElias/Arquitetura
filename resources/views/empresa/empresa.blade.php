@extends('layouts.master')
@section('main-content')
<div class="breadcrumb">
    <h1>Selecione a empresa para Navegar</h1>
    <ul>
        <li><a href="">Dashboard</a></li>
        <li>Empresa</li>
    </ul>
</div>

<div class="separator-breadcrumb border-top"></div>

    <div class="row">
        <div class="col-12 col-md-6">
            <a href="/empresa/nova" class="btn btn-success btn-lg m-1"><i class="nav-icon  i-Add-Window"></i> Nova Empresa</a>
            <a href="/empresa/vinculo" class="btn btn-secundary btn-lg m-1"><i class="nav-icon i-Add-User"></i> Solicitar Vínculo</a>
        </div>
        <div class="col-12 col-md-6">
            <div class="form-group row">
                <div class="col-12">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="desc-empresa" placeholder="Buscar Empresa" aria-label="Buscar Empresa" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-raised-success" id="search" type="button"><i class="search-icon text-muted i-Magnifi-Glass1"></i> Buscar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
   <div class="row" id="busca">
    <?php foreach ($empresas as $empresa): ?>
        <div class="col-md-3">
            <div class="card card-custom mb-4">
             <?php if($empresa->status == 0 || $empresa->status == 2)
                       {?>
              				<a href="#" class="card-body text-center">
                  <?php }
                        elseif($empresa->status == 1){?>
                       		<a href="/empresa/<?php echo($empresa->id);?>/status" class="card-body text-center">
                  <?php }?>

                    <h2 class="mb-3"><?php echo($empresa->nome_fantasia);?></h2>
                    <p><?php if($empresa->status == 0)
                             {?>
								<span class="btn btn-warning m-1">Status: Pendente</span>
                       <?php }
                            elseif($empresa->status == 1){?>
                                 <span class="btn btn-success m-1">Status: Aprovado</span>
                             <?php }else{?>
                                 <span class="btn btn-danger m-1">Status: Reprovado</span>
                             <?php }?>
                             </p>
                    <h3 class="cnpj">CNPJ: <?php echo($empresa->cnpj);?></h3>
                    <p>Endereço: <?php echo($empresa->endereco . ', ' . $empresa->numero . ' - ' . $empresa->cidade);?></p>
                    <hr>
                    <h4><i class="nav-icon i-Medal-2"></i> Responsável: <br /> <strong><?php echo($empresa->nome);?></strong></h4>
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
<script src="{{asset('assets/js/empresa/empresa.js')}}"></script>
<script src="{{asset('assets/js/sistema.js')}}"></script>
@endsection
