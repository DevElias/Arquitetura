@extends('layouts.master')
@section('main-content')
<div class="breadcrumb">
    <h1 id="nomeprojeto"></h1>
    <ul>
        <li><a href="">Dashboard</a></li>
        <li>Orçamentos</li>
    </ul>
</div>

<div class="separator-breadcrumb border-top"></div>
  <div class="row">
    @include('projetos.sidebar-projeto',[$sobre = '', $cronograma = '',  $orcamento = 'active', $financeiro2 = '',  $reuniao = '',  $notificacao = '',  $projetos = '',  $usuarios2 = ''])
    <div class="col-12 col-md-10">
        <div class="card card-padrao">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <h2>Criar itens para a escolha</h2>
                    </div>
                    <div class="col-12">
                    <form id="formulario" action="#">
                        <input type="hidden" id="idprojeto" name="idprojeto">
                    <div class="modal-body">
                        <div class="form-group row">
                            <div class="col-12 col-md-6">
                                <label for="descricao">Selecione a Categoria</label>
                                <select class="form-control-rounded form-control" name="categoria" id="categoria">
                                <?php foreach ($itens['categorias'] as $categoria): ?>
                                <option value="<?php echo($categoria->id);?>"<?php if($categoria->id == $itens['produtos'][0]->id_categoria): ?> selected="selected" <?php endif; ?>><?php echo($categoria->nome);?></option>
                                <?php endforeach; ?>
                                    </select>
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="pergunta">Detalhes Pergunta*</label>
                                <input type="text"
                                    class="form-control-rounded form-control"
                                    name="pergunta" value="<?php echo $itens['produtos'][0]->pergunta; ?>"
                                    required>
                            </div>
                            <div class="col-12">
                                <h3 class="padding-top20">Adicionar Produtos para Escolha:</h3>
                                <p>Clique em "Adicionar nova opção" para adicionar mais de uma opção para a escolha do cliente</p>
                            </div>
                        </div>
                        <?php $cont= 1; foreach ($itens['produtos'] as $produto): ?>
                        <div id="clonedSection<?php echo $cont; ?>" class="clonedSection">
                            <input type="hidden" name="idproduto<?php echo $cont; ?>" value="<?php echo($produto->id);?>" id="idproduto<?php echo $cont; ?>">
                            <div class="form-group row">
                                <div class="col-6 col-md-3">
                                        <label for="descricao<?php echo $cont; ?>">Descrição*</label>
                                        <input type="text"
                                            class="form-control-rounded form-control"
                                            name="descricao<?php echo $cont; ?>" id="descricao<?php echo $cont; ?>" value="<?php echo($produto->descricao);?>"
                                            required>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label for="unidade<?php echo $cont; ?>">Unidade*</label>
                                        <input type="text"
                                            class="form-control-rounded form-control"
                                            name="unidade<?php echo $cont; ?>" id="unidade<?php echo $cont; ?>" value="<?php echo($produto->unidade);?>"
                                            required>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label for="valorunitario<?php echo $cont; ?>">Valor Uni.*</label>
                                        <input type="text"
                                            class="form-control-rounded form-control"
                                            name="valorunitario<?php echo $cont; ?>"
                                            id="valorunitario<?php echo $cont; ?>"
                                            value="<?php echo(number_format($produto->valor, 2, ',', '.'));?>"
                                            required>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label for="total">Total</label>
                                        <input type="text"
                                            class="form-control-rounded form-control"
                                            name="total<?php echo $cont; ?>"
                                            id="total<?php echo $cont; ?>"
                                            value="<?php echo(number_format($produto->total, 2, ',', '.'));?>"
                                              required
                                            >
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label for="link">Link</label>
                                        <input type="text"
                                            class="form-control-rounded form-control"
                                            name="link<?php echo $cont; ?>"
                                            id="link<?php echo $cont; ?>"
                                            value="<?php echo($produto->link);?>"
                                              required
                                            >
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label class="custom-file-label form-control-rounded form-control" for="documento<?php echo $cont; ?>">Escolha o Arquivo</label>
                                        <input type="file" name="documento<?php echo $cont; ?>" class="custom-file-input" id="documento<?php echo $cont; ?>" onchange='readURL<?php echo $cont; ?>(this)'>
                                        <input type="hidden" name="url<?php echo $cont; ?>"  value="<?php echo($produto->documento);?>" id="url<?php echo $cont; ?>">
                                        <span id="msgupload<?php echo $cont; ?>" class="msgupload"></span>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label for="adicionais<?php echo $cont; ?>">Dados adicionais</label>
                                        <input type="text"
                                            class="form-control-rounded form-control"
                                            name="adicionais<?php echo $cont; ?>" id="adicionais<?php echo $cont; ?>"  value="<?php echo($produto->adicionais);?>" required
                                            >
                                    </div>
                                    <div class="col-6 col-md-3">
                                    <span onclick="calcularValor(<?php echo $cont; ?>)" class="btn btn-paddingtop">Calcular</span>
                                    </div>
                                    <div class="col-6 col-md-3">
                                    <button  style="margin-top:43px;" onclick="ExcluirItem(<?php echo($produto->id);?>)" class="btn btn-outline-danger">Excluir Item</button>
                                    </div>
                            </div>
                        </div>
                        <?php $cont++; endforeach; ?>
                    </div>
                    <div class="modal-footer">
                    <a href="/projeto/<?php echo $_SESSION['idprojeto']; ?>/orcamentos/produtos" class="btn btn-secondary">Voltar</a>
                    <span class="btn btn-danger" onclick="ExcluirtemProduto('<?php echo $itens['produtos'][0]->id_pai; ?>')">Excluir</span>
                    <span class="btn btn-primary" id="atualizaritens" onclick="EditarItensPergunta('<?php echo $itens['produtos'][0]->id_pai; ?>')">Atualizar Itens</span>
                    </div>

                </form>
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
<script src="{{asset('assets/js/orcamento/orcamento.js')}}"></script>
<script>
$(document).ready(function () {
    $("#valorunitario1").mask('#.##0,00', {
            reverse: true
        });
    $("#total1").mask('#.##0,00', {
        reverse: true
    });
    $("#valorunitario2").mask('#.##0,00', {
            reverse: true
        });
    $("#total2").mask('#.##0,00', {
        reverse: true
    });
    $("#valorunitario3").mask('#.##0,00', {
            reverse: true
        });
    $("#total3").mask('#.##0,00', {
        reverse: true
    });
    $("#valorunitario4").mask('#.##0,00', {
            reverse: true
        });
    $("#total4").mask('#.##0,00', {
        reverse: true
    });
    $("#valorunitario5").mask('#.##0,00', {
            reverse: true
        });
    $("#total5").mask('#.##0,00', {
        reverse: true
    });
});
</script>
@endsection
