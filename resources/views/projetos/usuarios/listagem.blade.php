@extends('layouts.master')
@section('main-content')
<div class="breadcrumb">
    <h1 id="nomeprojeto"></h1>
    <ul>
        <li><a href="">Dashboard</a></li>
        <li>Usuários</li>
    </ul>
</div>

<div class="separator-breadcrumb border-top"></div>
    <div class="row">
        @include('projetos.sidebar-projeto',[$sobre = '', $cronograma = '',  $orcamento = '', $financeiro2 = '',  $reuniao = '',  $notificacao = '',  $projetos = '',  $usuarios2 = 'active'])
        <div class="col-12 col-md-10">
            <div class="card card-padrao">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <h2>Usuários</h2>
                        </div>
                        <div class="col-12 col-md-6 text-right padding-bottom20">
                        <button class="btn btn-primary"  data-toggle="modal" data-target="#novoConvite">Convidar Cliente</button>
                        </div>
                            <div class="col-12 col-md-12">
                                    <div class="table-responsive tabela-custom">
                                        <table class="display table table-striped table-bordered" id="dados-usuarios" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Nome</th>
                                                    <th>Email</th>
                                                    <th>Tel</th>
                                                    <th>Cel</th>
                                                    <?php if($_SESSION['tipo'] == 0): ?> <th>Ações</th><?php endif; ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php foreach ($usuarios as $value):?>
                                                <tr>
                                                    <td><?php echo($value->nome);?></td>
                                                    <td><?php echo($value->email);?></td>
                                                    <td><?php echo($value->telefone);?></td>
                                                    <td><?php echo($value->whatsapp);?></td>
                                                    <?php if($_SESSION['tipo'] == 0): ?>
                                                    <td>
                                                    <a class="btn btn-primary"href="/edit/usuario/<?php echo($value->id);?>/projeto/<?php echo($value->Projeto);?>">Editar</a>
                                                     <button onclick="ExcluirRelacao(<?php echo($value->id);?>)" class="btn btn-outline-danger">Excluir</button>
                                                    </td>
                                                    <?php endif; ?>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                <th>Nome</th>
                                                    <th>Email</th>
                                                    <th>Tel</th>
                                                    <th>Cel</th>
                                                    <?php if($_SESSION['tipo'] == 0): ?> <th>Ações</th><?php endif; ?>
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

<!-- Modal -->
<div class="modal fade" id="novoConvite" tabindex="-1" role="dialog" aria-labelledby="novoConviteLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="novoConviteLabel">Novo Convite</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" id="formulario">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nome">Nome</label>
                        <input id="nome" type="text"
                            class="form-control-rounded form-control"
                            name="nome"  required
                            autofocus>
                    </div>
                    <div class="form-group row">
                        <div class="col-12">
                            <label for="email">Email</label>
                            <input id="email" type="email"
                                class="form-control-rounded form-control"
                                name="email"  required
                                autofocus>
                        </div>
                        <input id="idprojeto" type="hidden"
                            class="form-control-rounded form-control"
                            name="idprojeto">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="button" id="gravar" class="btn btn-primary">Criar Convite</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('page-js')
<script src="{{asset('assets/js/vendor/echarts.min.js')}}"></script>
<script src="{{asset('assets/js/es5/echart.options.min.js')}}"></script>
<script src="{{asset('assets/js/es5/dashboard.v1.script.js')}}"></script>
<script src="{{asset('assets/js/vendor/datatables.min.js')}}"></script>
<script src="{{asset('assets/js/jquery.mask.min.js')}}"></script>
<script src="{{asset('assets/js/jquery-confirm.js')}}"></script>
<script src="{{asset('assets/js/sistema.js')}}"></script>
<script src="{{asset('assets/js/projeto/descricao.js')}}"></script>
<script src="{{asset('assets/js/usuario/convida.js')}}"></script>
<script>
    $(document).ready(function () {
        // zero table
        $('#dados-usuarios').DataTable({
            "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Portuguese-Brasil.json"
        }
        }); // feature enable/disable
    });
</script>
@endsection
