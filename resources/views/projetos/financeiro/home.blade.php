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
                        <h2>Financeiro</h2>
                    </div>
                    <div class="col-12 col-md-6 text-right">
                    <?php if($_SESSION['tipo'] == 0): ?> <a href="{{ url('/projeto/') }}/<?php echo $_SESSION['idprojeto'];  ?>/financeiro/novo" class="btn btn-primary">Adicionar Pagamento</a><?php endif; ?>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="card card-custom mb-4">
                            <a href="financeiro/agenda" class="card-body text-center">
                                <p>Financeiro</p>
                                <h2>Agenda</h2>
                            </a>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="card card-custom mb-4">
                            <a href="financeiro/fluxodecaixa" class="card-body text-center">
                                <p>Financeiro</p>
                                <h2>Fluxo de Caixa</h2>
                            </a>
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
@endsection
