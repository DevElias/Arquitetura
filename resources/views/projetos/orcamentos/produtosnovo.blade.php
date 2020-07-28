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
                                      <?php foreach ($detalhes['categorias'] as $categoria): ?>
                                        <option value="<?php echo($categoria->id);?>"><?php echo($categoria->nome);?></option>
                                    <?php endforeach; ?>
                                    </select>
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="pergunta">Detalhes Pergunta*</label>
                                <input type="text"
                                    class="form-control-rounded form-control"
                                    name="pergunta"
                                    required>
                            </div>
                            <div class="col-12">
                                <h3 class="padding-top20">Adicionar Produtos para Escolha:</h3>
                                <p>Clique em "Adicionar nova opção" para adicionar mais de uma opção para a escolha do cliente</p>
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
                                            id="unidade"
                                            required>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label for="valorunitario">Valor Uni.*</label>
                                        <input type="text"
                                        id="valorunitario"
                                            class="form-control-rounded form-control"
                                            name="valorunitario"
                                            required>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label for="total">Total</label>
                                        <input type="text"
                                        id="total"
                                            class="form-control-rounded form-control"
                                            name="total"  required
                                            >
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label for="link">Link</label>
                                        <input type="text"
                                            class="form-control-rounded form-control"
                                            name="link"  required
                                            >
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label class="custom-file-label form-control-rounded form-control" for="documento">Escolha o Arquivo</label>
                                        <input type="file" name="documento" class="custom-file-input" id="documento" onchange='readURL(this)'>
                                        <input type="hidden" name="url" id="url">
                                        <span id="msgupload" class="msgupload"></span>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label for="adicionais">Dados adicionais</label>
                                        <input type="text"
                                            class="form-control-rounded form-control"
                                            name="adicionais" id="adicionais"  required
                                            >
                                    </div>
                            </div>
                        </div>
                            <div class="row">
                                <div class="col-12">
                                    <span class="btn btn-outline-primary" id="btnAdd">Adicionar nova opção</span>
                                    <span class="btn btn-outline-danger" id="btnDel">Remover opção</span>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <span type="button" class="btn btn-secondary">Close</span>
                        <span type="button" class="btn btn-primary" id="gravar">Criar Item</span>
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

        $("#valorunitario").mask('#.##0,00', {
            reverse: true
        });
        $("#total").mask('#.##0,00', {
            reverse: true
        });

        //Custom add Campos
        $('#btnAdd').click(function() {
            var num     = $('.clonedSection').length;
            var newNum  = new Number(num + 1);


            console.log(num);

            var newSection = $('#clonedSection' + num).clone().attr('id', 'clonedSection' + newNum);

            newSection.children(':first').children(':first').children(':nth-child(2)').attr('id', 'descricao' + newNum).attr('name', 'descricao' + newNum).val('');
            newSection.children(':first').children(':nth-child(2)').children(':nth-child(2)').attr('id', 'unidade' + newNum).attr('name', 'unidade' + newNum).val('');
            newSection.children(':first').children(':nth-child(3)').children(':nth-child(2)').attr('id', 'valorunitario' + newNum).attr('name', 'valorunitario' + newNum).val('').mask('#.##0,00', {reverse: true});
            newSection.children(':first').children(':nth-child(4)').children(':nth-child(2)').attr('id', 'total' + newNum).attr('name', 'total' + newNum).val('').mask('#.##0,00', {reverse: true});
            newSection.children(':first').children(':nth-child(5)').children(':nth-child(2)').attr('id', 'link' + newNum).attr('name', 'link' + newNum).val('');
            newSection.children(':first').children(':nth-child(6)').children(':nth-child(1)').attr('for', 'documento' + newNum);
            newSection.children(':first').children(':nth-child(6)').children(':nth-child(2)').attr('id', 'documento' + newNum).attr('name', 'documento' + newNum).attr('onChange', 'readURL'+ newNum +'(this)').val('');
            newSection.children(':first').children(':nth-child(6)').children(':nth-child(3)').attr('id', 'url' + newNum).attr('name', 'url' + newNum).val('');
            newSection.children(':first').children(':nth-child(6)').children(':nth-child(4)').attr('id', 'msgupload' + newNum).html('');
            newSection.children(':first').children(':nth-child(7)').children(':nth-child(2)').attr('id', 'adicionais' + newNum).attr('name', 'adicionais' + newNum).val('');

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

    });
</script>
@endsection
