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
    @include('projetos.sidebar-projeto',[$sobre = '', $cronograma = '',  $orcamento = '', $financeiro2 = 'active',  $reuniao = '',  $notificacao = '',  $projetos = '',  $usuarios2 = ''])
    <div class="col-12 col-md-10">
        <div class="card card-padrao">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <h2>Adicionar Pagamento</h2>
                    </div>
                    <div class="col-12">
                        <form action="#" id="formulario">
                        <div class="form-group row">
                            <div class="col-12 col-md-4">
                                <label for="descricao">Descrição</label>
                                <input type="text" class="form-control-rounded form-control" name="descricao">
                            </div>
                            <div class="col-12 col-md-4">
                                <label for="categoria">Selecione a Categoria</label>
                                    <select class="form-control-rounded form-control" name="categoria" id="categoria">
                                      <?php foreach ($detalhes['categorias'] as $categoria): ?>
                                        <option value="<?php echo($categoria->id);?>"><?php echo($categoria->nome);?></option>
                                    <?php endforeach; ?>
                                    </select>
                            </div>
                            <div class="col-12 col-md-4">
                                <label for="data">Dia do Pagamento</label>
                                <input type="text" class="form-control-rounded form-control" name="data" id="data">
                            </div>
                        </div>
                            <div class="form-group row">
                                <div class="col-6 col-md-3">
                                        <label for="parcelas">Número de Parcelas</label>
                                        <input type="text"
                                            class="form-control-rounded form-control"
                                            name="parcelas" id="parcelas"
                                            required>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label for="comeco">Replicar Pagamento</label>
                                        <select class="form-control-rounded form-control" name="replicar" id="replicar">
                                        <option value="0">Nenhum</option>
                                        <option value="1">Semanal</option>
                                        <option value="2">Quinzenal</option>
                                        <option value="3">Mensal</option>
                                        </select>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <input type="file" class="custom-file-input" id="customFile">
                                        <label class="custom-file-label form-control-rounded form-control" for="customFile">Escolha o Arquivo</label>
                                        <span id="msgupload"></span>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label for="executor">Status</label>
                                        <select name="status" class="form-control-rounded form-control" id="status">
                                            <option value="0">Em aberto</option>
                                            <option value="1">Atrasado</option>
                                            <option value="2">Em análise</option>
                                            <option value="3">Pago</option>
                                            <option value="4">Excluido</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label for="categoria">Valor da Parcela</label>
                                            <input type="text"
                                            class="form-control-rounded form-control"
                                            name="valor" id="valor"
                                            required>
                                    </div>
                                    <div class="col-12">
                                        <label for="executor">Detalhes</label>
                                        <textarea  rows="3"
                                            class="form-control-rounded form-control"
                                            name="detalhe" ide="detalhe"  required
                                            ></textarea>
                                            <input type="hidden" class="form-control-rounded form-control" name="idprojeto" id="idprojeto">
                                            <input type="hidden" class="form-control-rounded form-control" name="url" id="url">
                                    </div>
                            </div>
                            <div class="row">
                                <div class="col-12 text-right">
                                    <a href="{{ url('/projeto/') }}/<?php echo $_SESSION['idprojeto'];  ?>/financeiro/agenda" class="btn btn-outline-primary">Voltar Agenda</a>
                                    <button type="button" class="btn btn-primary" id="gravar">Adicionar Pagamento</button>
                                </div>
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
<script src="{{asset('assets/js/financeiro/financeiro.js')}}"></script>
@endsection
