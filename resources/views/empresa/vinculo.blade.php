@extends('layouts.master')
@section('main-content')
<div class="breadcrumb">
    <h1>Solicitar vinculo com Empresas</h1>
    <ul>
        <li><a href="">Dashboard</a></li>
        <li>Solicitar Vinculo</li>
    </ul>
</div>

<div class="separator-breadcrumb border-top"></div>

    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-center">
                <div class="col-12 col-md-6">
                    <div class="input-group input-group-lg mb-3">
                        <input type="text" class="form-control" id="cnpj-empresa" placeholder="Digite o CNPJ" aria-label="Digite o CNPJ" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-success" id="solicitar" type="button"><i class="nav-icon i-Add-User"></i> Solicitar Vínculo</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
    <?php foreach ($soicitacoes as $soicitacao): ?>
        <div class="col-md-3">
            <div class="card card-custom mb-4">
            <?php if($_SESSION['tipo'] == '0')
                  {
            ?>
                <a href="/empresa/<?php echo($soicitacao->id);?>/my-drive" class="card-body text-center">
            <?php }else{?>
            	<a href="#" class="card-body text-center">
              <?php }?>
                <p>Solicita&ccedil;&atilde;o para: </p>
                    <h2 class="mb-3"><?php echo($soicitacao->nome_fantasia);?></h2>
                     <p><?php if($soicitacao->status == 0)
                             {?>
								<span class="btn btn-warning m-1">Status: Pendente</span>
                       <?php }
                             elseif($soicitacao->status == 1){?>
                                 <span class="btn btn-success m-1">Status: Aprovado</span>
                             <?php }else{?>
                                 <span class="btn btn-danger m-1">Status: Reprovado</span>
                             <?php }?>
                             </p>
                    <h3 class="cnpj">CNPJ: <?php echo($soicitacao->cnpj);?></h3>
                    <p>Endereço: <?php echo($soicitacao->endereco . ', ' . $soicitacao->numero . ' - ' . $soicitacao->cidade);?></p>
                    <hr>
                    <h4><i class="nav-icon i-Medal-2"></i> Responsável: <br /> <strong><?php echo($soicitacao->nome);?></strong></h4>
                </a>
            </div>
        </div>
      <?php endforeach; ?>
    </div>

@endsection

@section('page-js')
<script src="{{asset('assets/js/vendor/echarts.min.js')}}"></script>
<script src="{{asset('assets/js/es5/echart.options.min.js')}}"></script>
<script src="{{asset('assets/js/es5/dashboard.v1.script.js')}}"></script>
<script src="{{asset('assets/js/jquery.mask.min.js')}}"></script>
<script src="{{asset('assets/js/jquery-confirm.js')}}"></script>
<script src="{{asset('assets/js/empresa/empresa.js')}}"></script>
<script src="{{asset('assets/js/sistema.js')}}"></script>
@endsection
