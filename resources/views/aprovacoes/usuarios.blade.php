@extends('layouts.master')
@section('main-content')
<div class="breadcrumb">
    <h1>Usuários</h1>
    <ul>
        <li><a href="">Dashboard</a></li>
        <li>Dados de Usuários</li>
    </ul>
</div>

<div class="separator-breadcrumb border-top"></div>

<div class="row">
    <div class="table-responsive">
        <table class="display table table-striped table-bordered" id="dados-clientes" style="width:100%">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Telefone</th>
                    <th>Whastapp</th>
                    <th>CPF</th>
                    <th>Status</th>
                    <th>Opções</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $cliente): ?>
                    <tr>
                        <td><?php echo($cliente->nome);?></td>
                        <td><?php echo($cliente->email);?></td>
                        <td class="tel"><?php echo($cliente->telefone);?></td>
                        <td class="whats"><?php echo($cliente->whatsapp);?></td>
                        <td class="cpf"><?php echo($cliente->cpf);?></td>
                        <td>
                        <?php if($cliente->status == 0)
                                {
                        ?>
                                <span class="btn btn-warning m-1">Pendente</span>
                        <?php }
                        elseif($cliente->status == 1){?>
                                <span class="btn btn-success m-1">Aprovado</span>
                        <?php }else{?>
                        <span class="btn btn-danger m-1">Reprovado</span>
                        <?php }?>
                        </td>
                        <?php
                        if($_SESSION['tipo'] == '0')
                                {
                            ?>
                                <td><a href="#" title="Aprovar" onclick="AprovarUsuario(<?php echo($cliente->id);?>);" class="aprovar"><i class="text-20 i-Like"></i></a> <a href="#" title="Reprovar" onclick="ReprovarUsuario(<?php echo($cliente->id);?>);" class="reprovar"><i class="text-20 i-Close-Window"></i></a></td>
                        <?php }else{?>
                                    <td></td>
                            <?php }?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                <th>Nome</th>
                    <th>Email</th>
                    <th>Telefone</th>
                    <th>Whastapp</th>
                    <th>CPF</th>
                    <th>Status</th>
                    <th>Opções</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

@endsection

@section('page-js')
<script src="{{asset('assets/js/vendor/echarts.min.js')}}"></script>
<script src="{{asset('assets/js/es5/echart.options.min.js')}}"></script>
<script src="{{asset('assets/js/es5/dashboard.v1.script.js')}}"></script>
<script src="{{asset('assets/js/vendor/datatables.min.js')}}"></script>
<script src="{{asset('assets/js/jquery.mask.min.js')}}"></script>
<script src="{{asset('assets/js/usuario/usuario.js')}}"></script>
<script src="{{asset('assets/js/jquery-confirm.js')}}"></script>
<script src="{{asset('assets/js/sistema.js')}}"></script>
<script>
    $(document).ready(function () {
        // zero table
        $('#dados-clientes').DataTable({
            "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Portuguese-Brasil.json"
        },
        });
    });
</script>
@endsection
