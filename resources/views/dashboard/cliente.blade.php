@extends('layouts.master')
@section('main-content')
<div class="breadcrumb">
    <h1>Dashboard</h1>
    <ul>
        <li><a href="">Dashboard</a></li>
        <li>Projetos Vinculados</li>
    </ul>
</div>

<div class="separator-breadcrumb border-top"></div>

<div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="row">
            <?php foreach ($projetos as $projeto): ?>
                <div class="col-md-3">
                    <div class="card card-custom mb-4">
                        <a href="/projeto/<?php echo($projeto->id);?>/status" class="card-body text-center">
                            <h2 class="mb-3"> <span class="subtitulo-projeto">Projeto</span><br /><?php echo($projeto->nome);?></h2>
                            <p>Clique aqui e veja detalhes do projeto</p>
                            <p>
                                <?php

                                    $html = '';

                                    if($projeto->status == 0)
                                    {
                                        $html = '<span class="btn btn-warning m-1">Status: Briefing</span>';
                                    }
                                    elseif($projeto->status == 1)
                                    {
                                        $html = '<span class="btn btn-success m-1">Status: Projeto</span>';
                                    }
                                    elseif($projeto->status == 2)
                                    {
                                        $html = '<span class="btn btn-success m-1">Status: Planejamento</span>';
                                    }
                                    elseif($projeto->status == 3)
                                    {
                                        $html = '<span class="btn btn-success m-1">Status: Obra</span>';
                                    }
                                    elseif($projeto->status == 4)
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
        </div>
    </div>

@endsection

@section('page-js')
<script src="{{asset('assets/js/vendor/echarts.min.js')}}"></script>
<script src="{{asset('assets/js/es5/echart.options.min.js')}}"></script>
<script src="{{asset('assets/js/es5/dashboard.v1.script.js')}}"></script>

@endsection
