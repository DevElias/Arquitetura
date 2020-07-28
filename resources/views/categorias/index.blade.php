@extends('layouts.master')
@section('main-content')
<div class="breadcrumb">
    <h1>Categorias</h1>
    <ul>
        <li><a href="">Dashboard</a></li>
        <li>Categorias</li>
    </ul>
</div>

<div class="separator-breadcrumb border-top"></div>
   <div class="row">
    <div class="col-12 btn-headernew">
        <button class="btn btn-lg btn-primary" data-toggle="modal" data-target="#novaCategoria">Nova Categoria</button>
        <!-- Modal -->

        <div class="modal fade" id="novaCategoria" tabindex="-1" role="dialog" aria-labelledby="novaCategoriaLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="novaCategoriaLabel">Nova Categoria</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="#">
                    <div class="modal-body">
                            <div class="form-group">
                                <label for="categoria">Nome da Categoria*</label>
                                <input id="nome" type="text"
                                    class="form-control-rounded form-control"
                                    name="nome"  required
                                    autofocus>
                            </div>
                            <div class="form-group">
                            <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" value="1" id="chk1">
                                    <label class="form-check-label" for="chk1">
                                        Cronogramas
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" value="2" id="chk2">
                                    <label class="form-check-label" for="chk2">
                                        Orçamentos
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" value="3" id="chk3">
                                    <label class="form-check-label" for="chk3">
                                        Financeiros
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" value="4" id="chk4">
                                    <label class="form-check-label" for="chk4">
                                        Reuniões
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" value="5" id="chk5">
                                    <label class="form-check-label" for="chk5">
                                        Notificações
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" value="6" id="chk6">
                                    <label class="form-check-label" for="chk6">
                                        Projetos
                                    </label>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" id="gravar" class="btn btn-primary">Criar Categoria</button>
                    </div>

                </form>
                </div>
            </div>
        </div>

        <!-- End Modal Insert -->

        <div class="modal fade" id="editarCategoria" tabindex="-1" role="dialog" aria-labelledby="editarCategoriaLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarCategoriaLabel">Nova Categoria</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="#" id="formedit">
                    <div class="modal-body">
                            <div class="form-group">
                                <label for="categoria">Nome da Categoria*</label>
                                <input id="editarnome" type="text"
                                    class="form-control-rounded form-control"
                                    name="editarnome"  required
                                    autofocus>
                            </div>
                            <div class="form-group">
                            <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" value="1" id="editarchk1">
                                    <label class="form-check-label" for="defaultCheck1">
                                        Cronogramas
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" value="2" id="editarchk2">
                                    <label class="form-check-label" for="defaultCheck2">
                                        Orçamentos
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" value="3" id="editarchk3">
                                    <label class="form-check-label" for="defaultCheck3">
                                        Financeiros
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" value="4" id="editarchk4">
                                    <label class="form-check-label" for="defaultCheck4">
                                        Reuniões
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" value="5" id="editarchk5">
                                    <label class="form-check-label" for="defaultCheck5">
                                        Notificações
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" value="6" id="editarchk6">
                                    <label class="form-check-label" for="defaultCheck6">
                                        Projetos
                                    </label>
                                </div>

                                <input id="idcategoria" type="hidden"
                                    class="form-control-rounded form-control"
                                    name="idcategoria">
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" id="editargravar" class="btn btn-primary">Editar Categoria</button>
                    </div>

                </form>
                </div>
            </div>
        </div>
    </div>
   <div class="col-12">
        <div class="table-responsive tabela-custom">
            <table class="display table table-striped table-bordered" id="dados-categorias" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Categoria</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($categorias as $categoria): ?>
                    <tr>
                        <td><?php echo($categoria->id);?></td>
                        <td><?php echo($categoria->nome);?></td>
                        <td>
                         <button class="btn btn-outline-primary" data-toggle="modal" data-target="#editarCategoria" onclick="Editar(<?php echo($categoria->id);?>)">Editar</button>
                         <button type="button" onclick="Excluir(<?php echo($categoria->id);?>)" class="btn btn-outline-danger">Excluir</button>
                        </td>
                 <?php endforeach; ?>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Categoria</th>
                        <th>Ações</th>
                    </tr>
                </tfoot>
            </table>
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
<script src="{{asset('assets/js/categoria/categoria.js')}}"></script>
<script src="{{asset('assets/js/jquery-confirm.js')}}"></script>
<script src="{{asset('assets/js/sistema.js')}}"></script>
<script>
    $(document).ready(function () {
        // zero table
        $('#dados-categorias').DataTable({
            "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Portuguese-Brasil.json"
        },
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
        }); // feature enable/disable
        setTimeout(
            function()
            {
                $('.buttons-print span').html('Imprimir')
            }, 500);
    });
</script>
@endsection
