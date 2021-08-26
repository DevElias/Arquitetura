@extends('layouts.master')
@section('main-content')
<?php $categoriafixa = "";
if(isset($_GET['categoria'])){
    $categoriafixa = $_GET['categoria'];
}  ?>
<div class="breadcrumb">
    <h1>Nova Empresa</h1>
    <ul>
        <li><a href="">Dashboard</a></li>
        <li>Nova Empresa</li>
    </ul>
</div>

<div class="separator-breadcrumb border-top"></div>
    <div class="row">
        @include('projetos.sidebar-projeto',[$sobre = '', $cronograma = '',  $orcamento = 'active', $financeiro2 = '',  $reuniao = '',  $notificacao = '',  $projetos = '',  $usuarios2 = ''])
        <div class="col-12 col-md-10">
            <div class="card card-padrao">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-9">
                            <h2> Orçamento </h2>
                        </div>
                        <div class="col-12 col-md-3 text-right">
                            <?php if($_SESSION['tipo'] == 0 || $_SESSION['tipo'] == 2): ?>
                                <a class="btn btn-outline-primary" href="/projeto/<?php echo($_SESSION['idprojeto']); ?>/orcamentos/excel/">Exporta Excel</a>
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
                                                <?php echo($itens[0]['nome']);?>
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
                                                                <th>Unidade</th>
                                                                <th>Valor Uni.</th>
                                                                <th>Total</th>
                                                                <?php if($_SESSION['tipo'] == 0 || $_SESSION['tipo'] == 2): ?> <th>Faturado</th><?php endif; ?>
                                                                <th>AV</th>
                                                                <?php if($_SESSION['tipo'] == 0 || $_SESSION['tipo'] == 2): ?><th style="width:235px">Ações</th><?php endif; ?>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach ($itens as $value):?>
                                                            <tr>
                                                                <td><?php echo($value['descricao']);?></td>
                                                                <td><?php echo($value['unidade']);?></td>
                                                                <td><?php echo(number_format($value['valor'], 2, ',', '.'));?></td>
                                                                <td><?php echo(number_format($value['total'], 2, ',', '.'));?></td>
                                                                <td><?php echo($value['faturado']);?></td>
                                                                <td><?php echo(round((($value['total'] / $detalhes['total'][0]->valortotal) * 100), 2));?> %</td>

                                                                <?php if($_SESSION['tipo'] == 0): ?>
                                                                <td>
                                                                <?php if($value['faturado'] == 'N'): ?>
                                                                    <a href="/projeto/<?php echo $_SESSION['idprojeto']; ?>/financeiro/novo/<?php echo($value['id']);?>" class="btn btn-outline-primary">Faturar</a>
                                                                    <button onclick="EditarItem(<?php echo($value['id']);?>)" class="btn btn-outline-primary" data-toggle="modal" data-target="#editarItem">Editar</button>
                                                                    <button  onclick="ExcluirItem(<?php echo($value['id']);?>)" class="btn btn-outline-danger">Excluir</button>
                                                                <?php endif; ?>
                                                                <?php if($value['faturado'] == 'S'): ?><button onclick="CancelarFaturamento(<?php echo($value['id']);?>)" class="btn btn-outline-primary">Cancelar Fatura</button><?php endif; ?>
                                                                </td>
                                                                <?php else: ?>
                                                                    <td>
                                                                    <button onclick="EditarItem(<?php echo($value['id']);?>)" class="btn btn-outline-primary" data-toggle="modal" data-target="#editarItem">Editar</button>
                                                                   <button  onclick="ExcluirItem(<?php echo($value['id']);?>)" class="btn btn-outline-danger">Excluir</button>
                                                                    </td>
                                                                <?php endif; ?>
                                                            </tr>
                                                            <?php endforeach; ?>
                                                            <tr>
                                                            <td><strong>Total</strong></td>
                                                            <td><strong><?php $sum = 0;
                                                                foreach ($itens as $value){
                                                                    $sum += $value['unidade'];
                                                                }
                                                                echo($sum); ?></strong></td>
                                                                <td><strong><?php $sum = 0;
                                                                foreach ($itens as $value){
                                                                    $sum += $value['valor'];
                                                                }
                                                                echo(number_format($sum, 2, ',', '.')); ?></strong></td>
                                                                <td>
                                                                <strong>
                                                                <?php $sum = 0;
                                                                foreach ($itens as $value){
                                                                    $sum += $value['total'];
                                                                }
                                                                echo(number_format($sum, 2, ',', '.')); ?></strong></td>
                                                                <td></td>
                                                                <td><strong>
                                                                <?php
                                                                $sum = 0;
                                                                foreach ($itens as $value){
                                                                    $sum += $value['total'];
                                                                }
                                                                 echo(round((($sum / $detalhes['total'][0]->valortotal) * 100), 2));?> %
                                                               </strong> </td>
                                                                <td></td>
                                                            </tr>
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th>Descrição</th>
                                                                <th>Unidade</th>
                                                                <th>Valor Uni.</th>
                                                                <th>Total</th>
                                                                <?php if($_SESSION['tipo'] == 0 || $_SESSION['tipo'] == 2): ?><th>Faturado</th><?php endif; ?>
                                                                <th>AV</th>
                                                                <?php if($_SESSION['tipo'] == 0 || $_SESSION['tipo'] == 2): ?><th>Ações</th><?php endif; ?>
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
                            <div class="col-12 ">
                                <div class="row totalizador">
                                    <div class="col-6">
                                        <h2>Total</h2>
                                    </div>
                                    <div class="col-3 text-right">
                                        <h2>R$ <?php echo(number_format($detalhes['total'][0]->valortotal, 2, ',', '.'));?></h2>
                                    </div>
                                    <div class="col-3">
                                        <h2>100%</h2>
                                    </div>
                                </div>
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
                    <input type="hidden" id="idprojeto" name="idprojeto">
                    <div class="modal-body">
                        <div class="form-group row">
                            <div class="col-12">
                                <label for="descricao">Selecione a Categoria</label>
                                    <select class="form-control-rounded form-control" name="categoria" id="categoria">
                                    <?php foreach ($detalhes['categorias'] as $categoria): ?>
                                        <option value="<?php echo($categoria->id);?>"><?php echo($categoria->nome);?></option>
                                    <?php endforeach; ?>
                                    </select>
                            </div>
                        </div>
                        <div id="clonedSection1" class="clonedSection">
                            <div class="form-group row">
                                <div class="col-6 col-md-3">
                                        <label for="descricao">Descrição*</label>
                                        <input type="text"
                                            class="form-control-rounded form-control"
                                            name="descricao"
                                            required>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label for="unidade">Unidade*</label>
                                        <input type="text"
                                            class="form-control-rounded form-control"
                                            name="unidade"
                                            required>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label for="valorunitario">Valor Uni.*</label>
                                        <input type="text" maxlength="9"
                                            class="form-control-rounded form-control"
                                            name="valorunitario" id="valorunitario"
                                            required>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label for="total">Total</label>
                                        <input type="text"maxlength="9"
                                            class="form-control-rounded form-control"
                                            name="total" id="total" required
                                            >
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
                        <button type="button" class="btn btn-primary" id="gravarAprovado">Criar Item</button>
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
                                    <select class="form-control-rounded form-control" name="categoria" id="editarcategoria">
                                    <?php foreach ($detalhes['categorias'] as $categoria): ?>
                                        <option value="<?php echo($categoria->id);?>"><?php echo($categoria->nome);?></option>
                                    <?php endforeach; ?>
                                    </select>
                            </div>
                        </div>
                            <div class="form-group row">
                                <div class="col-6 col-md-3">
                                        <label for="descricao">Descrição*</label>
                                        <input type="text"
                                            class="form-control-rounded form-control"
                                            name="descricao" id="descricaoedit"
                                            required>
                                            <input type="hidden"
                                            class="form-control-rounded form-control"
                                            name="iditem" id="iditem">
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label for="unidade">Unidade*</label>
                                        <input type="text"
                                            class="form-control-rounded form-control"
                                            name="unidade" id="unidadeedit"
                                            required>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label for="valorunitario">Valor Uni.*</label>
                                        <input type="text"
                                            class="form-control-rounded form-control"
                                            name="valorunitario" id="valorunitarioedit"
                                            required>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label for="totaledit">Total</label>
                                        <input type="text"
                                            class="form-control-rounded form-control"
                                            name="totaledit" id="totaledit"  required
                                            >
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
<script src="{{asset('assets/js/empresa/empresa.js')}}"></script>
<script src="{{asset('assets/js/jquery-confirm.js')}}"></script>
<script src="{{asset('assets/js/sistema.js')}}"></script>
<script src="{{asset('assets/js/orcamento/orcamento.js')}}"></script>
<script>
    $(document).ready(function () {
        //Custom add Campos
        $('#btnAdd').click(function() {
            var num     = $('.clonedSection').length;
            var newNum  = new Number(num + 1);

            var newSection = $('#clonedSection' + num).clone().attr('id', 'clonedSection' + newNum);

            newSection.children(':first').children(':first').children(':nth-child(2)').attr('id', 'descricao' + newNum).attr('name', 'descricao' + newNum).val('');
            newSection.children(':first').children(':nth-child(2)').children(':nth-child(2)').attr('id', 'unidade' + newNum).attr('name', 'unidade' + newNum).val('');
            newSection.children(':first').children(':nth-child(3)').children(':nth-child(2)').attr('id', 'valorunitario' + newNum).attr('name', 'valorunitario' + newNum).val('').mask('#.##0,00', {reverse: true});
            newSection.children(':first').children(':nth-child(4)').children(':nth-child(2)').attr('id', 'total' + newNum).attr('name', 'total' + newNum).val('').mask('#.##0,00', {reverse: true});

            $('.clonedSection').last().append(newSection)

            $('#btnDel').prop("disabled", false);

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
