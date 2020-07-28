@extends('layouts.master')
@section('main-content')
<div class="breadcrumb">
    <h1>Detalhes Reunião</h1>
    <ul>
        <li><a href="">Dashboard</a></li>
        <li>Reunião</li>
    </ul>
</div>

<div class="separator-breadcrumb border-top"></div>
  <div class="row">
    @include('projetos.sidebar-projeto',[$sobre = '', $cronograma = '',  $orcamento = '', $financeiro2 = '',  $reuniao = 'active',  $notificacao = '',  $projetos = '',  $usuarios2 = ''])
    <div class="col-12 col-md-10">
        <div class="card card-padrao">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <h4><strong>Reunião dia <?php echo($detalhes['reuniao']->data);?> - Das <?php echo($detalhes['reuniao']->hora_inicio);?> às <?php echo($detalhes['reuniao']->hora_fim);?></strong></h4>
                    </div>
                    <div class="col-12  col-md-6 text-right">
                        <a href="{{ url('/projeto/') }}/<?php echo $_SESSION['idprojeto'];  ?>/reunioes" class="btn btn-secondary" id="excluir">Voltar</a>
                        <?php if($_SESSION['tipo'] != 0){?>
                        <button class="btn btn-primary" id="confirmar">Confirmar Presença</button>
                        <?php }?>
                        <?php if($_SESSION['tipo'] == 0): ?>
                        <a href="<?php echo($detalhes['reuniao']->id);?>/editar" class="btn btn-primary">Editar</a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <h4><strong>Descrição</strong></h4>
                        <p><?php echo($detalhes['reuniao']->descricao);?></p>
                    </div>
                    <div class="col-12 col-md-6">
                        <h4><strong>Endereço</strong></h4>
                        <p><?php echo($detalhes['reuniao']->localizacao);?></p>
                    </div>
                    <div class="col-12 col-md-6">
                        <h4><strong>Convidados</strong></h4>
                         <?php foreach ($detalhes['participantes'] as $value):?>
                          <?php

                            $status = '';

                            if($value->status_panticipante == 0)
                            {
                                $status = 'Pendente';
                            }
                            elseif($value->status_panticipante == 1)
                            {
                                $status = 'Confirmado';
                            }
                            elseif($value->status_panticipante == 2)
                            {
                                $status = 'Rejeitado';
                            }

                            ?>
                        <p><?php echo($value->nome);?> -  <?php echo($status);?></p>
                      <?php endforeach; ?>
                    </div>
                    <div class="col-12 col-md-6">
                        <h3>Documentos</h3>
                    </div>
                    <div class="col-12 col-md-6 text-right">
                        <button data-toggle="modal" data-target="#novoUpload" class="btn btn-primary">Upload Arquivo</button>
                    </div>
                    <div class="col-12">
                        <div class="card">
                        <table class="display table table-striped table-bordered" id="categoria1" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Descrição</th>
                                    <th>Documento</th>
                                    <th>Download</th>
                                    <th>Link</th>
                                    <th>Status</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($detalhes['documentos'] as $value):?>

                            <?php

                            $status = '';

                            if($value->status == 0)
                            {
                                $status = 'Pendente';
                                $mda = '';
                            }
                            elseif($value->status == 1)
                            {
                                $status = 'Aprovado';
                                $mda = ' por ' . $value->nome . ' em ' . $value->datinha;
                            }
                            elseif($value->status == 2)
                            {
                                $status = 'Reprovado';
                                $mda = ' por ' . $value->nome . ' em ' . $value->datinha;
                            }

                            ?>

                                <tr>
                                    <td><?php echo($value->descricao);?></td>
                                    <td><?php echo($value->documento);?></td>
                                    <td><a href="<?php echo($value->arquivo);?>" target="_blank">Download</a></td>
                                    <td><a href="<?php echo($value->link);?>" target="_blank">Link</a></td>
                                    <td><?php echo($status);?> <?php echo($mda);?></td>
                                    <td>
                                    <?php if($_SESSION['tipo'] == 0): ?>
                                    <button class="btn btn-primary"  data-toggle="modal" data-target="#editUpload" onclick="EditarDocumento(<?php echo($value->id);?>)">Editar</button>
                                    <button onclick="ExcluirDocumento(<?php echo($value->id);?>)" class="btn btn-outline-danger">Excluir</button>
                                    <?php endif; ?>
                                    <button class="btn btn-primary"  onclick="AprovarDocumento(<?php echo($value->id);?>)">Aprovar</button>
                                    <button class="btn btn-outline-danger"  onclick="ReprovarDocumento(<?php echo($value->id);?>)">Reprovar</button>
                                    </td>
                                </tr>
                              <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Descrição</th>
                                    <th>Documento</th>
                                    <th>Download</th>
                                    <th>Link</th>
                                    <th>Status</th>
                                    <th>Ações</th>
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
<div class="modal fade" id="novoUpload" tabindex="-1" role="dialog" aria-labelledby="novoUploadLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="novoUploadLabel">Novo Documento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" id="formdocumento">
                <div class="modal-body">
                <div class="form-group">
                        <label for="descricao">Descrição</label>
                        <input id="descricao" type="text"
                            class="form-control-rounded form-control"
                            name="descricao"  required
                            autofocus>
                    </div>
                    <div class="form-group">
                        <label for="documento">Documento</label>
                        <input id="documento" type="text"
                            class="form-control-rounded form-control"
                            name="documento"  required
                            autofocus>
                    </div>
                    <div class="form-group">
                        <label for="link">Link</label>
                        <input id="link" type="text"
                            class="form-control-rounded form-control"
                            name="link">
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" class="form-control-rounded form-control" id="status">
                            <option value="0">Pendente</option>
                            <option value="1">Aprovado</option>
                            <option value="2">Rejeitado</option>
                        </select>
                    </div>
                    <div class="form-group">
                            <input type="file" class="custom-file-input" id="customFile">
                            <label class="custom-file-label2 form-control-rounded form-control" for="customFile">Escolha o Arquivo</label>
                        <input id="idprojeto" type="hidden" class="form-control-rounded form-control" name="idprojeto" value="<?php echo($detalhes['reuniao']->id_projeto);?>">
                        <input id="idreuniao" type="hidden" class="form-control-rounded form-control" name="idreuniao" value="<?php echo($detalhes['reuniao']->id);?>">
                        <input id="url" type="hidden" class="form-control-rounded form-control" name="url" >
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="button" id="gravardocumento" class="btn btn-primary">Enviar Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="editUpload" tabindex="-1" role="dialog" aria-labelledby="editUploadLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="novoUploadLabel">Editar Documento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" id="formdocumentoedit">
                <div class="modal-body">
                <div class="form-group">
                        <label for="descricaoedit">Descrição</label>
                        <input id="descricaoedit" type="text"
                            class="form-control-rounded form-control"
                            name="descricaoedit"  required
                            autofocus>
                    </div>
                    <div class="form-group">
                        <label for="documentoedit">Documento</label>
                        <input id="documentoedit" type="text"
                            class="form-control-rounded form-control"
                            name="documentoedit"  required
                            autofocus>
                    </div>
                    <div class="form-group">
                        <label for="linkedit">Link</label>
                        <input id="linkedit" type="text"
                            class="form-control-rounded form-control"
                            name="linkedit">
                    </div>
                    <div class="form-group">
                        <label for="statusedit">Status</label>
                        <select name="statusedit" class="form-control-rounded form-control" id="statusedit">
                            <option value="0">Pendente</option>
                            <option value="1">Aprovado</option>
                            <option value="2">Rejeitado</option>
                        </select>
                    </div>
                    <div class="form-group">
                            <input type="file" class="custom-file-input" id="customFile">
                            <label class="custom-file-label2 form-control-rounded form-control" for="customFile">Escolha o Arquivo</label>
                        <input id="idprojeto" type="hidden" class="form-control-rounded form-control" name="idprojeto" value="<?php echo($detalhes['reuniao']->id_projeto);?>">
                        <input id="idreuniao" type="hidden" class="form-control-rounded form-control" name="idreuniao" value="<?php echo($detalhes['reuniao']->id);?>">
                        <input id="urledit" type="hidden" class="form-control-rounded form-control" name="urledit" >
                        <input id="idocumento" type="hidden" class="form-control-rounded form-control" name="idocumento" >
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="button" id="editardocumento" class="btn btn-primary">Atualizar Documento</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reprovarItemLabel">Reprovar Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#">
                <div class="modal-body">
                <div class="form-group">
                        <label for="motivo">Motivo da reprovação?</label>
                        <input id="motivo" type="text"
                            class="form-control-rounded form-control"
                            name="motivo"  required
                            autofocus>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="button" id="gravarMotivo" class="btn btn-primary">Enviar</button>
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
<script src="{{asset('assets/js/jquery.mask.min.js')}}"></script>
<script src="{{asset('assets/js/jquery-confirm.js')}}"></script>
<script src="{{asset('assets/js/sistema.js')}}"></script>
<script src="{{asset('assets/js/reuniao/reuniao.js')}}"></script>
@endsection
