@extends('layouts.master')
@section('main-content')
<div class="breadcrumb">
    <h1>Infos Gerais</h1>
    <ul>
        <li><a href="">Infos Gerais</a></li>
        <li>Admin</li>
    </ul>
</div>

<div class="separator-breadcrumb border-top"></div>
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="row">
                <!-- ICON BG-->
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <a class="card card-icon-bg card-icon-bg-primary o-hidden mb-4"   href="/projeto/novo">
                        <div class="card-body"><span class="icon-sidebar icon-projetos"></span>
                            <div class="content-fluid">
                                <h2 class="text-24 line-height-1 m-0">+</h2>
                                <p class="text-muted mt-2 mb-2">Criação de Projetos</p>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- ICON BG-->
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <a class="card card-icon-bg card-icon-bg-primary o-hidden mb-4"  href="/projeto">
                        <div class="card-body"><span class="icon-sidebar icon-projetos"></span>
                            <div class="content-fluid">
                                <h2 class="text-24 line-height-1 m-0"><?php echo $projetosativos ?></h2>
                                <p class="text-muted mt-2 mb-2">Projetos Ativos</p>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- ICON BG-->
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <a class="card card-icon-bg card-icon-bg-primary o-hidden mb-4"  href="#">
                        <div class="card-body"><span class="icon-sidebar icon-projetos"></span>
                            <div class="content-fluid">
                                <h2 class="text-24 line-height-1 m-0"><?php echo $projetoconcluido ?></h2>
                                <p class="text-muted mt-2 mb-2">Projetos Concluídos</p>
                            </div>
                        </div>
                    </a>
                </div>
                 <!-- ICON BG-->
                 <div class="col-lg-3 col-md-6 col-sm-6">
                    <a class="card card-icon-bg card-icon-bg-primary o-hidden mb-4"  href="/dados/clientes">
                        <div class="card-body"><span class="icon-sidebar icon-usuarios"></span>
                            <div class="content-fluid">
                                <h2 class="text-24 line-height-1 m-0"><?php echo $usuariosativos ?></h2>
                                <p class="text-muted mt-2 mb-2">Usuários Cadastrados</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-js')
<script src="{{asset('assets/js/vendor/echarts.min.js')}}"></script>
<script src="{{asset('assets/js/es5/echart.options.min.js')}}"></script>
<script src="{{asset('assets/js/es5/dashboard.v1.script.js')}}"></script>

@endsection
