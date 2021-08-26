@extends('layouts.master')
@section('main-content')
<div class="breadcrumb">
    <h1 id="nomeprojeto"></h1>
    <ul>
        <li><a href="">Dashboard</a></li>
        <li>Projeto</li>
    </ul>
</div>

<div class="separator-breadcrumb border-top"></div>
  <div class="row">
    @include('projetos.sidebar-projeto',[$sobre = '', $cronograma = '',  $orcamento = '', $financeiro2 = '',  $reuniao = '',  $notificacao = '',  $projetos = 'active',  $usuarios2 = ''])
    <div class="col-12 col-md-10">
        <div class="card card-padrao">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <h2>Adicionar Projeto</h2>
                    </div>
                    <div class="col-12">
                        <form action="#" id="formulario">
                        <div class="form-group row">
                            <div class="col-12 col-md-6">
                                <label for="descricao">Descrição</label>
                                <input type="text" class="form-control-rounded form-control" name="descricao" required>
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="categoria">Selecione a Categoria</label>
                                    <select class="form-control-rounded form-control" name="categoria" id="categoria">
                                      <?php foreach ($detalhes['categorias'] as $categoria): ?>
                                        <option value="<?php echo($categoria->id);?>"><?php echo($categoria->nome);?></option>
                                    <?php endforeach; ?>
                                    </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-12 col-md-6">
                                <label for="documento">Nome do Arquivo</label>
                                <input type="text" class="form-control-rounded form-control" name="documento">
                            </div>

                            <div class="col-6 col-md-6">
                                        <input type="file" class="custom-file-input" id="customFile">
                                        <label class="custom-file-label form-control-rounded form-control" for="customFile">Escolha o Arquivo</label>
                                        <span id="msgupload"></span>
                                    </div>
                        </div>
                            <div class="form-group row">
                                <div class="col-12 col-md-2">
                                    <label for="data">Prancha</label>
                                    <input type="text" class="form-control-rounded form-control" name="prancha" />
                                </div>
                                <div class="col-6 col-md-2">
                                        <label for="escala">Escala</label>
                                        <input type="text"
                                            class="form-control-rounded form-control"
                                            name="escala" id="escala"
                                            required>
                                    </div>
                                    <div class="col-6 col-md-2">
                                        <label for="executor">Status</label>
                                        <select name="status" class="form-control-rounded form-control" id="status">
                                            <option value="0">Pendente</option>
                                            <option value="1">Aprovado</option>
                                            <option value="2">Reprovado</option>
                                            <option value="3">Excluido</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-2">
                                        <label for="categoria">Previsto</label>
                                            <input type="text"
                                            class="form-control-rounded form-control"
                                            name="previsto" id="previsto"
                                            required>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label for="link">Link</label>
                                            <input type="text"
                                            class="form-control-rounded form-control"
                                            name="link" id="link"
                                            >
                                    </div>
                                    <div class="col-12">
                                        <label for="detalhe">Detalhes</label>
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
                                    <a href="{{ url('/projeto/') }}/<?php echo $_SESSION['idprojeto'];  ?>/anexos" class="btn btn-outline-primary">Voltar Projetos</a>
                                    <button type="button" class="btn btn-primary" id="gravar">Adicionar Projeto</button>
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
<script src="{{asset('assets/js/anexo/anexo.js')}}"></script>
@endsection
