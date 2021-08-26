@extends('layouts.master')
@section('main-content')
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
                            <h2> Orçamento Produtos</h2>
                        </div>
                        <div class="col-12 col-md-3 text-right">
                        <?php if($_SESSION['tipo'] == 0 || $_SESSION['tipo'] == 2): ?> <a class="btn btn-primary" href="/projeto/<?php  echo $_SESSION['idprojeto'] ?>/orcamentos/produtos/novo">Adicionar Item</a><?php endif; ?>
                        </div>
                            <div class="col-12">
                                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="pendente-tab" data-toggle="pill" href="#pills-pendente" role="tab" aria-controls="pills-pendente" aria-selected="true">Pendentes</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="aprovados-tab" data-toggle="pill" href="#pills-aprovados" role="tab" aria-controls="pills-aprovados" aria-selected="false">Aprovados</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="reprovados-tab" data-toggle="pill" href="#pills-reprovados" role="tab" aria-controls="pills-reprovados" aria-selected="false">Reprovados</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="pills-tabContent">
                                <!-- Inicio Pendente -->
                                <div class="tab-pane fade show active" id="pills-pendente" role="tabpanel" aria-labelledby="pendente-tab">
                                <div id="accordion">
                                <?php $x = 0; foreach ($detalhes['itens'] as $itens): ?>
                                    <div class="card">
                                        <div class="card-header" id="heading<?php echo($itens[0]['id_pai']);?>">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link <?php if($x > 0): ?>collapsed<?php endif; ?>" data-toggle="collapse" data-target="#collapse<?php echo($itens[0]['id_pai']);?>" aria-expanded="true" aria-controls="collapse<?php echo($itens[0]['id_pai']);?>">
                                                <?php echo($itens[0]['pergunta']);?>
                                                </button>
                                            </h5>
                                        </div>
                                        <div id="collapse<?php echo($itens[0]['id_pai']);?>"
                                        <?php  if($x == 0){ echo 'class="collapse show"'; }else {echo 'class="collapsed collapse"';}  ?>
                                        aria-labelledby="heading<?php echo($itens[0]['id_pai']);?>" data-parent="#accordion">
                                            <div class="card-body">
                                                 <div class="card-body">
                                                <form action="#" class="formulario-escolha" id="form<?php echo($itens[0]['id_pai']);?>">
                                                    <div class="row">
                                                    <?php foreach ($itens as $value):?>
                                                        <div class="col-12 col-md-4">
                                                            <label class="conteudo-opcao">
                                                            <input type="radio" name="produto<?php echo($itens[0]['id_pai']);?>" value="<?php echo($value['id']);?>" class="radiohide">
                                                            <?php if($value['documento'] != ""):?> <img src="<?php echo($value['documento']);?>" class="w-100"><?php endif;?>
                                                            <p class="titulo-produto"><?php echo($value['descricao']);?></p>
                                                            <?php if($_SESSION['tipo'] == 0 || $_SESSION['tipo'] == 2):?> <p><strong>Preço:</strong> R$ <?php echo(number_format($value['valor'], 2, ',', '.'));?><br /><?php endif;?>
                                                            <strong>Unidade:</strong> <?php echo($value['unidade']);?><br />
                                                            <strong>Total:</strong> R$ <?php echo(number_format($value['total'], 2, ',', '.'));?><br />
                                                            <?php if($value['link'] != ""):?> <strong>Link:</strong><a href="<?php echo($value['link']);?>" class="btn btn-default"  target="_blank">Clique aqui</a> <?php endif;?>
                                                                <?php if($value['adicionais'] != ""):?> <br /><strong>Fornecedor: </strong><?php echo($value['adicionais']);?> <?php endif;?>
                                                            </p>
                                                            </label>
                                                        </div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                    <div class="col-12 text-center">

                                                    <span class="btn btn-outline-danger" onClick="reprovarItemModal('<?php echo($itens[0]['id_pai']);?>')"  data-toggle="modal" data-target="#reprovarItemModal">Reprovar</span>
                                                    <span class="btn btn-primary" onClick="AprovarItemProduto('<?php echo($itens[0]['id_pai']);?>')">Aprovar</span>
                                                    <?php if($_SESSION['tipo'] == 0 || $_SESSION['tipo'] == 2): ?> <span class="btn btn-danger" onClick="ExcluirtemProduto('<?php echo($itens[0]['id_pai']);?>')">Excluir</span><?php endif; ?>
                                                    <?php if($_SESSION['tipo'] == 0 || $_SESSION['tipo'] == 2): ?> <a href="/projeto/<?php echo $_SESSION['idprojeto']; ?>/orcamentos/produtos/editar/<?php echo($itens[0]['id_pai']);?>" class="btn btn-alert">Editar</a><?php endif; ?>
                                                    </div>

                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                    <script>
                                    $(document).ready(function() {
                                        $("#form<?php echo($itens[0]['id_pai']);?> label").on("click",function() {
                                                $('#form<?php echo($itens[0]['id_pai']);?> label').removeClass('ativo');
                                                $(this).addClass('ativo');
                                            });
                                        });

                                        </script>
                                    <?php $x++; endforeach; ?>
                                    </div>
                                <!-- Fim do colapse!-->
                                </div>
                                <!-- Fim Pendente -->
                                <div class="tab-pane fade" id="pills-reprovados" role="tabpanel" aria-labelledby="reprovados-tab">
                                    <!-- conteudo Reprovado -->
                                    <div id="accordion3">
                                    <?php $x2 = 0; foreach ($detalhes['itensreprovados'] as $itensreprovado): ?>
                                        <div class="card">
                                            <div class="card-header" id="heading<?php echo($itensreprovado[0]['id_pai']);?>">
                                                <h5 class="mb-0">
                                                    <button class="btn btn-link <?php if($x2 > 0): ?>collapsed<?php endif; ?>" data-toggle="collapse" data-target="#collapse<?php echo($itensreprovado[0]['id_pai']);?>" aria-expanded="true" aria-controls="collapse<?php echo($itensreprovado[0]['id_pai']);?>">
                                                    <?php echo($itensreprovado[0]['nome']);?>
                                                    </button>
                                                </h5>
                                            </div>
                                            <div id="collapse<?php echo($itensreprovado[0]['id_pai']);?>"
                                            <?php  if($x2 == 0){ echo 'class="collapse show"'; }else {echo 'class="collapsed collapse"';}  ?>
                                            aria-labelledby="heading<?php echo($itensreprovado[0]['id_pai']);?>" data-parent="#accordion3">
                                                <div class="card-body">
                                                    <div class="card-body">
                                                        <div class="row">
                                                        <?php foreach ($itensreprovado as $valuereprovado):?>
                                                            <div class="col-12 col-md-4">
                                                                <div class="conteudo-opcao">
                                                                <?php if($valuereprovado['documento'] != ""):?><img src="<?php echo($valuereprovado['documento']);?>" class="w-100"><?php endif;?>
                                                                <p class="titulo-produto"><?php echo($valuereprovado['descricao']);?></p>
                                                        <?php if($_SESSION['tipo'] == 0 || $_SESSION['tipo'] == 2):?><p><strong> Preço:</strong> R$ <?php echo(number_format($valuereprovado['valor'], 2, ',', '.'));?><br /><?php endif;?>
                                                                <strong>Unidade:</strong> <?php echo($valuereprovado['unidade']);?><br />
                                                                <strong>Total: </strong> R$  <?php echo(number_format($valuereprovado['total'], 2, ',', '.'));?><br />
                                                                <?php if($valuereprovado['link'] != ""):?> <strong>Link:</strong><a href="<?php echo($valuereprovado['link']);?>" class="btn btn-default" href="#">Clique aqui</a></p><?php endif;?>
                                                                    <?php if($valuereprovado['adicionais'] != ""):?>  <br /><strong>Fornecedor: </strong><?php echo($valuereprovado['adicionais']);?> <?php endif;?>
                                                                    <h2>
                                                                    Motivo:<br />
                                                                <?php if($valuereprovado['motivo'] != ""):?>
                                                                <?php echo($valuereprovado['motivo']);?>
                                                                <?php else:?>
                                                                Outro produto foi aprovado
                                                                <?php endif;?>
                                                                </h2>
                                                                <button  onclick="ExcluirItem(<?php echo($valuereprovado['id_orcamento']);?>)" class="btn btn-outline-danger">Excluir</button>
                                                            </div>
                                                            </div>
                                                            <?php endforeach; ?>
                                                        </div>

                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                        <?php $x2++; endforeach; ?>
                                        </div>
                                    <!-- Fim do colapse!-->
                                    <!-- fim do conteudo Aprovado -->
                                </div>
                                <!-- fim Aprovado -->
                                <div class="tab-pane fade" id="pills-aprovados" role="tabpanel" aria-labelledby="aprovados-tab">
                               <!-- conteudo Aprovados -->
                               <div id="accordion2">
                                <?php $x2 = 0; foreach ($detalhes['itensaprovados'] as $itensaprovado): ?>
                                    <div class="card">
                                        <div class="card-header" id="heading<?php echo($itensaprovado[0]['id_pai']);?>">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link <?php if($x2 > 0): ?>collapsed<?php endif; ?>" data-toggle="collapse" data-target="#collapse<?php echo($itensaprovado[0]['id_pai']);?>" aria-expanded="true" aria-controls="collapse<?php echo($itensaprovado[0]['id_pai']);?>">
                                                <?php echo($itensaprovado[0]['nome']);?>
                                                </button>
                                            </h5>
                                        </div>
                                        <div id="collapse<?php echo($itensaprovado[0]['id_pai']);?>"
                                        <?php  if($x2 == 0){ echo 'class="collapse show"'; }else {echo 'class="collapsed collapse"';}  ?>
                                        aria-labelledby="heading<?php echo($itensaprovado[0]['id_pai']);?>" data-parent="#accordion2">
                                            <div class="card-body">
                                                 <div class="card-body">
                                                    <div class="row">
                                                    <?php foreach ($itensaprovado as $valueaprovados):?>
                                                        <div class="col-12 col-md-4">
                                                            <div class="conteudo-opcao">
                                                            <?php if($valueaprovados['documento'] != ""):?><img src="<?php echo($valueaprovados['documento']);?>" class="w-100"><?php endif; ?>
                                                            <p class="titulo-produto"><?php echo($valueaprovados['descricao']);?></p>
                                                            <?php if($_SESSION['tipo'] == 0 || $_SESSION['tipo'] == 2):?><p> <strong>Preço:</strong> R$ <?php echo(number_format($valueaprovados['valor'], 2, ',', '.'));?><br /><?php endif; ?>
                                                            <strong>Unidade:</strong> <?php echo($valueaprovados['unidade']);?><br />
                                                            <strong>Total:</strong> R$ <?php echo(number_format($valueaprovados['total'], 2, ',', '.'));?><br />
                                                    <?php if($valueaprovados['link'] != ""):?><strong>Link:</strong> <a href="<?php echo($valueaprovados['link']);?>" target="_blank" class="btn btn-default">Clique aqui</a></p><?php endif; ?>
                                                        <?php if($valueaprovados['adicionais'] != ""):?> <br /><strong>Fornecedor: </strong><?php echo($valueaprovados['adicionais']);?> <?php endif;?>
                                                            </div>
                                                        </div>
                                                        <?php endforeach; ?>
                                                    </div>

                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                    <?php $x2++; endforeach; ?>
                                    </div>
                                <!-- Fim do colapse!-->
                                <!-- fim do conteudo Reprovado -->

                                </div>
                                <!-- Fim Reprovado -->
                                </div>
                                <!-- Colapse !-->

                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="reprovarItemModal" tabindex="-1" role="dialog" aria-labelledby="reprovarItemModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reprovarItemModalLabel">ExcluirItem</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="#" id="formReprovar">
                    <div class="modal-body">
                        <div class="form-group row">
                            <div class="col-12">
                                <p>Digite o motivo para a reprovação das opções enviadas:</p>
                                    <label for="motivo">Motivo*</label>
                                    <input type="text"
                                        class="form-control-rounded form-control"
                                        name="motivo"
                                        required>
                                        <input type="hidden"
                                        class="form-control-rounded form-control"
                                        name="idpai" id="idpai"
                                        required>
                                </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-danger" onClick="ReprovarItemProduto()">Reprovar Itens</button>
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

            newSection.children(':first').children(':first').attr('id', 'name' + newNum).attr('name', 'name' + newNum);
            newSection.children(':nth-child(2)').children(':first').attr('id', 'nameTwo' + newNum).attr('name', 'nameTwo' + newNum);

            $('.clonedSection').last().append(newSection)

            $('#btnDel').attr('disabled','');

            if (newNum == 5)
                $('#btnAdd').attr('disabled','disabled');
        });

        $('#btnDel').click(function() {
            console.log('clickei');
            var num = $('.clonedSection').length; // how many "duplicatable" input fields we currently have
            $('#clonedSection' + num).remove();     // remove the last element

            // enable the "add" button
            $('#btnAdd').attr('disabled','');

            // if only one element remains, disable the "remove" button
            console.log(num-1 == 1);
            if (num-1 == 1)
                $('#btnDel').attr('disabled','disabled');
        });

        $('#btnDel').attr('disabled','disabled');

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
