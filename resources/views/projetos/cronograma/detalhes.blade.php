@extends('layouts.master')
@section('main-content')
<?php $categoriafixa = "";
if(isset($_GET['categoria'])){
    $categoriafixa = $_GET['categoria'];
}  ?>
<div class="breadcrumb">
     <h1 id="nomeprojeto"></h1>
    <ul>
        <li><a href="">Dashboard</a></li>
        <li>Cronograma</li>
    </ul>
</div>

<div class="separator-breadcrumb border-top"></div>
    <div class="row">
        @include('projetos.sidebar-projeto',[$sobre = '', $cronograma = 'active',  $orcamento = '', $financeiro2 = '',  $reuniao = '',  $notificacao = '',  $projetos = '',  $usuarios2 = ''])
        <div class="col-12 col-md-10">
            <div class="card card-padrao">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-9">
                            <h2> Cronograma</h2>
                        </div>
                        <div class="col-12 col-md-3 text-right">
                            <?php if($_SESSION['tipo'] == 0): ?>
                            <button class="btn btn-primary"  data-toggle="modal" data-target="#novoItem">Adicionar Item</button>
                            <?php endif; ?>
                        </div>
                            <div class="col-12">
                                <!-- Colapse !-->
                                <div id="accordion">
                                <?php $x = 0; foreach ($detalhes['itens'] as $itens): ?>
                                    <div class="card">
                                        <div class="card-header" id="heading<?php echo($itens[0]['id_categoria']);?>">
                                            <h5 class="mb-0">
                                <button class="btn btn-link <?php if($x > 0 && !$categoriafixa): ?>collapsed <?php endif; ?> <?php if($categoriafixa == $itens[0]['id_categoria'] ): ?>teste <?php endif; ?>" data-toggle="collapse" data-target="#collapse<?php echo($itens[0]['id_categoria']);?>" aria-expanded="true" aria-controls="collapse<?php echo($itens[0]['id_categoria']);?>">
                                                <?php echo($itens[0]['nome']); ?>
                                                </button>
                                            </h5>
                                        </div>
                                        <div id="collapse<?php echo($itens[0]['id_categoria']);?>"
                                        <?php  if($x == 0 && !$categoriafixa){ echo 'class="collapse show"'; }elseif($categoriafixa == $itens[0]['id_categoria']){ echo 'class="collapse show"'; } else {echo 'class="collapsed collapse"';}  ?>
                                        aria-labelledby="heading<?php echo($itens[0]['id_categoria']);?>" data-parent="#accordion">
                                            <div class="card-body">
                                                <div class="table-responsive tabela-custom">
                                                    <table class="display table table-striped table-bordered" id="categoria1" style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                 <th>Descrição</th>
                                                                 <?php if($_SESSION['tipo'] == 0): ?><th>Executor</th><?php endif; ?>
                                                                <th>Prancha</th>
                                                                <th>Timeline Start</th>
                                                                <th>Timeline End</th>
                                                                <?php if($_SESSION['tipo'] == 0): ?><th>Ações</th><?php endif; ?>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                         <?php foreach ($itens as $value):?>
                                                            <tr>
                                                               <td><?php echo($value['descricao']);?></td>
                                                               <?php if($_SESSION['tipo'] == 0): ?><td><?php echo($value['executor']);?></td><?php endif; ?>
                                                                <td><?php echo($value['prancha']);?></td>
                                                                <td><?php echo($value['inicio']);?></td>
                                                                <td><?php echo($value['fim']);?></td>
                                                                <?php if($_SESSION['tipo'] == 0): ?>
                                                                    <td>
                                                                <button class="btn btn-primary"  data-toggle="modal" data-target="#editarItem" onclick="EditarItem(<?php echo($value['id']);?>)">Editar</button>
                                                                <a href="#" onclick="ExcluirItem(<?php echo($value['id']);?>)" class="btn btn-outline-danger">Excluir</a>
                                                                </td>
                                                                <?php endif; ?>
                                                            </tr>
                                                             <?php endforeach; ?>
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th>Descrição</th>
                                                                <?php if($_SESSION['tipo'] == 0): ?><th>Executor</th><?php endif; ?>
                                                               <th>Prancha</th>
                                                                <th>Timeline Start</th>
                                                                <th>Timeline End</th>
                                                                <?php if($_SESSION['tipo'] == 0): ?> <th>Ações</th><?php endif; ?>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php $x++; endforeach; ?>
                                </div>
                                <!-- Fim do colapse!-->
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="novoItem" tabindex="-1" role="dialog" aria-labelledby="novaCategoriaLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="novaCategoriaLabel">Novo Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="#" id="formulario">
                    <div class="modal-body">
                        <div class="form-group row">
                            <div class="col-12">
                                <label for="descricao">Selecione a Categoria</label>
                                    <select class="form-control-rounded form-control" name="categoria" id="categoria">
                                    <?php foreach ($detalhes['categorias'] as $categoria): ?>
                                        <option value="<?php echo($categoria->id);?>"><?php echo($categoria->nome);?></option>
                                    <?php endforeach; ?>
                                    </select>
                                     <input type="hidden"
                                            class="form-control-rounded form-control"
                                            name="cronograma" id="cronograma">
                                    <input type="hidden" id="idprojetocriacao" value="<?php echo($_SESSION['idprojeto']); ?>">
                            </div>
                        </div>
                        <div id="clonedSection1" class="clonedSection">
                            <div class="form-group row">
                                <div class="col-6 col-md-6">
                                        <label for="descricao">Descrição*</label>
                                        <input type="text"
                                            class="form-control-rounded form-control"
                                            name="descricao" id="descricao"
                                            required>
                                </div>
                                <div class="col-6 col-md-6">
                                    <label for="prancha">Prancha*</label>
                                    <input type="text"
                                        class="form-control-rounded form-control"
                                        name="prancha" id="prancha"
                                        required>
                                </div>
                                <div class="col-6 col-md-3">
                                    <label for="comeco">Começo*</label>
                                    <input type="text"
                                        class="form-control-rounded form-control comeco"
                                        name="comeco" id="comeco"
                                        required>
                                </div>
                                    <div class="col-6 col-md-3">
                                        <label for="fim">Fim*</label>
                                        <input type="text"
                                            class="form-control-rounded form-control fim"
                                            name="fim" id="fim"
                                            required>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label for="executor">Executor</label>
                                        <input type="text"
                                            class="form-control-rounded form-control"
                                            name="executor" ide="executor"  required
                                            >
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label for="executor">Status</label>
                                        <select name="status" class="form-control-rounded form-control" id="status">
                                            <option value="0">Em andamento</option>
                                            <option value="1">Concluído</option>
                                            <option value="2">Pausado</option>
                                            <option value="3">Cancelado</option>
                                            <option value="4">Excluido</option>
                                        </select>
                                    </div>
                            </div>
                        </div>
                            <div class="row">
                                <div class="col-12">
                                    <span class="btn btn-outline-primary" id="btnAdd">Adionar Novo Item</span>
                                    <span class="btn btn-outline-danger" id="btnDel">Remover Novo Item</span>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        <button type="button" class="btn btn-primary" id="gravar">Criar Cronograma</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <!--  edit modal -->
    <div class="modal fade" id="editarItem" tabindex="-1" role="dialog" aria-labelledby="novaCategoriaLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="novaCategoriaLabel">Editar Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="#" id="formedit">
                    <div class="modal-body">
                        <div class="form-group row">
                            <div class="col-12">
                                <label for="descricao">Selecione a Categoria</label>
                                    <select class="form-control-rounded form-control" name="editarcategoria" id="editarcategoria">
                                    <?php foreach ($detalhes['categorias'] as $categoria): ?>
                                        <option value="<?php echo($categoria->id);?>"><?php echo($categoria->nome);?></option>
                                    <?php endforeach; ?>
                                    </select>
                                    <input type="hidden"
                                            class="form-control-rounded form-control"
                                            name="editarcronograma" id="editarcronograma">
                                            <input type="hidden" value="<?php echo($_SESSION['idprojeto']);?>"
                                            class="form-control-rounded form-control"
                                            name="iddoprojetoeditar" id="iddoprojetoeditar">
                                     <input type="hidden"
                                            class="form-control-rounded form-control"
                                            name="iditem" id="iditem">
                            </div>
                        </div>
                        <div id="clonedSection1" class="clonedSection2">
                            <div class="form-group row">
                                <div class="col-6 col-md-6">
                                        <label for="descricao">Descrição*</label>
                                        <input type="text"
                                            class="form-control-rounded form-control"
                                            name="editardescricao" id="editardescricao"
                                            required>
                                    </div>
                                    <div class="col-6 col-md-6">
                                        <label for="comeco">Prancha*</label>
                                        <input type="text"
                                            class="form-control-rounded form-control"
                                            name="editarprancha" id="editarprancha"
                                            required>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label for="comeco">Começo*</label>
                                        <input type="text"
                                            class="form-control-rounded form-control comeco"
                                            name="editarcomeco" id="editarcomeco"
                                            required>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label for="fim">Fim*</label>
                                        <input type="text"
                                            class="form-control-rounded form-control fim"
                                            name="editarfim" id="editarfim"
                                            required>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label for="executor">Executor</label>
                                        <input type="text"
                                            class="form-control-rounded form-control"
                                            name="editarexecutor" id="editarexecutor"  required
                                            >
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label for="executor">Status</label>
                                        <select name="editarstatus" class="form-control-rounded form-control" id="editarstatus">
                                            <option value="0">Em andamento</option>
                                            <option value="1">Concluído</option>
                                            <option value="2">Pausado</option>
                                            <option value="3">Cancelado</option>
                                            <option value="4">Excluido</option>
                                        </select>
                                    </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        <button type="button" class="btn btn-primary" id="editargravar">Atualizar Item</button>
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
<script src="{{asset('assets/js/cronograma/itens.js')}}"></script>
<script src="{{asset('assets/js/jquery-confirm.js')}}"></script>
<script src="{{asset('assets/js/sistema.js')}}"></script>
<script src="{{asset('assets/js/projeto/descricao.js')}}"></script>
<script>
    $(document).ready(function () {
        //Custom add Campos
        $('#btnAdd').click(function() {
            var num     = $('.clonedSection').length;
            var newNum  = new Number(num + 1);

            console.log(num);

            var newSection = $('#clonedSection' + num).clone().attr('id', 'clonedSection' + newNum);

            newSection.children(':first').children(':first').children(':nth-child(2)').attr('id', 'descricao' + newNum).attr('name', 'descricao' + newNum).val('');
            newSection.children(':first').children(':nth-child(2)').children(':nth-child(2)').attr('id', 'prancha' + newNum).attr('name', 'prancha' + newNum).val('');
            newSection.children(':first').children(':nth-child(3)').children(':nth-child(2)').attr('id', 'comeco' + newNum).attr('name', 'comeco' + newNum).val('');
            newSection.children(':first').children(':nth-child(4)').children(':nth-child(2)').attr('id', 'fim' + newNum).attr('name', 'fim' + newNum).val('');
            newSection.children(':first').children(':nth-child(5)').children(':nth-child(2)').attr('id', 'executor' + newNum).attr('name', 'executor' + newNum).val('');
            newSection.children(':first').children(':nth-child(6)').children(':nth-child(2)').attr('id', 'status' + newNum).attr('name', 'status' + newNum).val('');

            $('.clonedSection').last().append(newSection)

            $('#btnDel').prop("disabled", false);

            $('#comeco' + newNum).mask('00/00/0000');
            $('#fim' + newNum).mask('00/00/0000');

            if (newNum == 5)
                $('#btnAdd').prop("disabled", true);
        });

        $('#btnDel').click(function() {
            console.log('clickei');
            var num = $('.clonedSection').length; // how many "duplicatable" input fields we currently have
            $('#clonedSection' + num).remove();     // remove the last element

            // enable the "add" button
            $('#btnAdd').prop("disabled", false);

            // if only one element remains, disable the "remove" button
            console.log(num-1 == 1);
            if (num-1 == 1)
                $('#btnDel').prop("disabled", true);
        });

        $('#btnDel').prop("disabled", true);

        $('#categoria1').DataTable( {
            "bPaginate": false, //hide pagination
            "bFilter": false, //hide Search bar
            "bInfo": false, // hide showing entries
        language: {
            url: '//cdn.datatables.net/plug-ins/1.10.20/i18n/Portuguese-Brasil.json'
        }
        });
    // Categorias
        $('#categoria2').DataTable( {
            "bPaginate": false, //hide pagination
            "bFilter": false, //hide Search bar
            "bInfo": false, // hide showing entries
            language: {
                url: '//cdn.datatables.net/plug-ins/1.10.20/i18n/Portuguese-Brasil.json'
            }
        });
    });
</script>
@endsection
