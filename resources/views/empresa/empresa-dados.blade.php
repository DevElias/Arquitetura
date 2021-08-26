@extends('layouts.master')
@section('main-content')
<div class="breadcrumb">
    <h1><?php echo($dados['info']->nome_fantasia);?></h1>
    <ul>
        <li><a href="">Dashboard</a></li>
        <li><a href="/empresa">Empresas</a></li>
        <li><?php echo($dados['info']->nome_fantasia);?></li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>
    <div class="row">
        <div class="col-12">
            <div class="card-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item"><a class="nav-link active show" id="home-basic-tab" data-toggle="tab" href="#homeBasic" role="tab" aria-controls="homeBasic" aria-selected="true">Arquivos</a></li>
                    <li class="nav-item"><a class="nav-link" id="profile-basic-tab" data-toggle="tab" href="#profileBasic" role="tab" aria-controls="profileBasic" aria-selected="false">Usuários</a></li>
                    <li class="nav-item"><a class="nav-link" id="profile-basic-tab" data-toggle="tab" href="#dadosempresa" role="tab" aria-controls="dadosempresa" aria-selected="false">Dados da Empresa</a></li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade active show" id="homeBasic" role="tabpanel" aria-labelledby="home-basic-tab">
                        <div class="row">
                        <?php if($_SESSION['tipo'] == '0'){?>
                            <div class="col-12 mb-4">
                                <div class="dropdown">
                                    <button class="btn btn-success btn-xl m-1 dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="nav-icon i-Data-Upload"></i>  Novo
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="#"  data-toggle="modal" data-target="#pastaModal">Pasta</a>
                                        <a class="dropdown-item" href="#"  data-toggle="modal" data-target="#arquivoModal">Upload Arquivo</a>
                                    </div>
                                </div>
                            </div>
                            <?php }?>
                            <div class="col-12">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="/empresa/"><?php echo($dados['info']->nome_fantasia);?></a></li>
                                        <li class="breadcrumb-item"><a href="/empresa/<?php echo($dados['info']->id);?>/my-drive">Raíz</a></li>
                                     <?php if(!empty($dados['breadcrumbs']))
                                          {
                                     ?>
                                        <?php foreach ($dados['breadcrumbs'] as $breadcrumbs): ?>
                                        	<li class="breadcrumb-item"><a><?php echo($breadcrumbs);?></a></li>
                                        <?php endforeach; ?>

                                     <?php }?>
                                    </ol>
                                </nav>
                            </div>
                            <?php foreach ($dados['conteudo'] as $conteudo): ?>
                                    <div class="col-md-3">
                                            <div class="card mb-4">
                                             <?php if($conteudo->tipo == 0)
                                                      {
                                                 ?>
                        								 <a href="/empresa/<?php echo($conteudo->id_empresa);?>/folders/<?php echo($conteudo->id_random);?>" class="card-body text-center">
                                               <?php }else{?>
                                               			<a href="<?php echo('/'.$conteudo->url);?>" download class="card-body text-center" >
                                                <?php }?>
                                                <?php if($conteudo->tipo == 0)
                                                      {
                                                 ?>
                        								 <p><i class="text-20 i-Folder"></i></p>
                                               <?php }else{?>
                                               			 <p><i class="text-20 i-File-Download"></i></p>
                                                <?php }?>
                                                    <h4 class="mb-3"> <?php echo($conteudo->descricao);?></h4>
                                                </a>
                                            </div>
                                        </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="profileBasic" role="tabpanel" aria-labelledby="profile-basic-tab">
                    <div class="table-responsive">
                        <div class="row">
                            <div class="col-12 mb-4">
                            <button class="btn btn-success btn-xl m-1" type="button" data-toggle="modal" data-target="#novoUserModal" >
                              <i class="nav-icon i-Business-Man"></i>  Novo Usuário
                            </button>
                            </div>
                        </div>
                                    <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Nome</th>
                                                <th>Email</th>
                                                <th>Status</th>
                                                <th>Opções</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php if(!empty($dados['solicitacoes']))
                                          {
                                     ?>
                                        <?php foreach ($dados['solicitacoes'] as $solicitacao): ?>
                                            <tr>
                                                <td>
                                                	 <?php if($solicitacao->solicitante_id == $dados['info']->id_responsavel)
                                                      {
                                                     ?>
                                                     <i class="nav-icon i-Medal-2"></i>
                                                     <?php }?>
                                                	<?php echo($solicitacao->solicitante);?>
                                                </td>
                                                <td><?php echo($solicitacao->solicitante_email);?></td>
                                                <td>
                                                	<?php if($solicitacao->solicitacao_status == 0)
                                                          {
                                                    ?>
															<span class="btn btn-warning m-1">Status: Pendente</span>
                       								<?php }
                       								elseif($solicitacao->solicitacao_status == 1){?>
                                 							<span class="btn btn-success m-1">Status: Aprovado</span>
                             						<?php }else{?>
                             						<span class="btn btn-danger m-1">Status: Reprovado</span>
                             						<?php }?>
                                                </td>
                                                <?php if($solicitacao->id_responsavel == $_SESSION['id'] || $_SESSION['tipo'] == 0 && $solicitacao->solicitacao_status != 2)
                                                      {
                                                ?>
                                                	<td><a href="#" title="Aprovar" onclick="AprovarSolicitacao(<?php echo($solicitacao->solicitacao_id);?>);" class="aprovar"><i class="text-20 i-Like"></i></a> <a href="#" onclick="ReprovarSolicitacao(<?php echo($solicitacao->solicitacao_id);?>);" title="Reprovar" class="reprovar"><i class="text-20 i-Close-Window"></i></a> <a href="#" onclick="TornarResponsael(<?php echo($solicitacao->solicitante_id);?>, <?php echo($solicitacao->empresa_id);?>);" class="responsavel" title="Tornar Responsável"><i class="text-20 i-Management"></i></a></td>
                                            	<?php }else{?>
                                            	<td></td>
                                            	<?php }?>
                                            </tr>
                                             <?php endforeach; ?>
                                             <?php }?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Nome</th>
                                                <th>Email</th>
                                                <th>Status</th>
                                                <th>Opções</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                    </div>
                    <div class="tab-pane fade" id="dadosempresa" role="tabpanel" aria-labelledby="dadosempresa-basic-tab">
                    <div class="row">
                        <div class="col-12">
                        <form method="POST" action="#">
                                <div class="form-group row">
                                    <div class="col-6">
                                        <label for="fantasia">Nome Fantasia</label>
                                        <input id="fantasia" type="text"
                                            class="form-control-rounded form-control"
                                            name="fantasia"  required value="<?php echo($dados['info']->nome_fantasia);?>"
                                            autofocus>
                                    </div>
                                    <div class="col-6">
                                        <label for="social">Razão Social</label>
                                        <input id="social" type="text"
                                            class="form-control-rounded form-control"
                                            name="social" value="<?php echo($dados['info']->razao_social); ?>"  required
                                            autofocus>
                                    </div>

                                </div>
                                <div class="form-group row">
                                    <div class="col-6">
                                        <label for="cnpj">CNPJ</label>
                                        <input id="cnpj" type="text"
                                            class="form-control-rounded form-control"
                                            name="cnpj" disabled="disabled" value="<?php echo($dados['info']->cnpj); ?>"
                                            autofocus>
                                    </div>
                                    <div class="col-6">
                                        <label for="email">Email</label>
                                        <input id="email" type="email"
                                            class="form-control-rounded form-control"
                                            name="email" value="<?php echo($dados['info']->email); ?>" required autocomplete="email">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-6">
                                            <label for="tel">Telefone</label>
                                            <input id="tel" type="text"
                                        class="form-control-rounded form-control"
                                        name="tel" value="<?php echo($dados['info']->telefone); ?>"  required
                                        autofocus>
                                        </div>
                                    <div class="col-6">
                                        <label for="whats">Whatsapp</label>
                                        <input id="whats" type="text"
                                        class="form-control-rounded form-control"
                                        name="whats" value="<?php echo($dados['info']->whatsapp); ?>"  required
                                        autofocus>
                                    </div>
                                </div>
                                <div class="form-group row">
                                <div class="col-3">
                                    <label for="cep">CEP</label>
                                    <input id="cep" type="text"
                                        class="form-control-rounded form-control"
                                        name="cep" value="<?php echo($dados['info']->cep); ?>" required
                                        autofocus>
                                </div>
                                <div class="col-6">
                                    <label for="endereco">Endereço</label>
                                    <input id="endereco" type="text"
                                        class="form-control-rounded form-control"
                                        name="endereco" value="<?php echo($dados['info']->endereco); ?>" required
                                        autofocus>
                                </div>
                                <div class="col-3">
                                    <label for="numero">Numero</label>
                                    <input id="numero" type="text"
                                        class="form-control-rounded form-control" value="<?php echo($dados['info']->numero); ?>"
                                        name="numero" required
                                        autofocus>
                                </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-3">
                                    <label for="complemento">Complemento</label>
                                    <input id="complemento" type="text"
                                        class="form-control-rounded form-control"
                                        name="complemento" value="<?php echo($dados['info']->complemento); ?>" required
                                        autofocus>
                                </div>
                                <div class="col-3">
                                        <label for="bairro">Bairro</label>
                                        <input id="bairro" type="text"
                                            class="form-control-rounded form-control"
                                            name="bairro" value="<?php echo($dados['info']->bairro); ?>" required
                                            autofocus>
                                    </div>
                                <div class="col-3">
                                        <label for="cidade">Cidade</label>
                                        <input id="cidade" type="text"
                                            class="form-control-rounded form-control"
                                            name="cidade" value="<?php echo($dados['info']->cidade); ?>" required
                                            autofocus>
                                    </div>
                                    <div class="col-3">
                                    <label for="estado">Estado</label>
                                        <input id="estado" type="text"
                                            class="form-control-rounded form-control"
                                            name="estado" value="<?php echo($dados['info']->estado); ?>" required
                                            autofocus>
                                    </div>
                                    <div class="col-6">
                                <label for="complemento">Segmento</label>
                                <input id="segmento" type="text"
                                    class="form-control-rounded form-control"
                                    name="complemento" value="<?php echo($dados['info']->segmento); ?>" required
                                    autofocus>
                            </div>
                                </div>
                                <div class="form-group text-right">
                                    <button type="button" id="atualizar-empresa" class="btn btn-primary btn-rounded mt-3">Atualizar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!--  Modal Pasta -->
    <div class="modal fade" id="pastaModal" tabindex="-1" role="dialog" aria-labelledby="pastaModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pastaModalLabel">Nova Pasta</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="descricao">Nome da Pasta</label>
                        <input id="descricao" type="text"
                            class="form-control-rounded form-control"
                            name="descricao"  required
                            autofocus>
                            <input type="hidden" id="idempresa" value="<?php echo($dados['info']->id);?>" name="pastaatual">
                     </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary ml-2" id="criar" type="button">Criar Pasta</button>
                </div>
            </div>
        </div>
    </div>
     <!--  Modal Arquivo -->
         <div class="modal fade" id="arquivoModal" tabindex="-1" role="dialog" aria-labelledby="arquivoModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="arquivoModalLabel">Upload de Arquivo</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                <form  id="multple-file-upload" action="{{ route('envia.arquivo') }}" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group">
                                 <input id="empresa" type="hidden" disable class="form-control-rounded form-control" name="empresa" value="<?php echo($dados['info']->id);?>" >
                                <input id="urlatual" type="hidden" disable class="form-control-rounded form-control" name="urlatual" value="<?php echo($_SERVER["REQUEST_URI"]);?>" >
                         </div>
                         <div class="form-group">
                        	<label for="file">Selecionar Arquivo</label>
                            <input type="file" name="file" class="form-control-rounded form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary ml-2" type="submit">Upload Arquivo</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
      <!--  Modal Novo Usuário -->
      <div class="modal fade" id="novoUserModal" tabindex="-1" role="dialog" aria-labelledby="novoUserModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="novoUserModalLabel">Novo Usuário</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="identificador">Digite o email ou CPF:</label>
                        <input id="identificador" type="text"
                            class="form-control-rounded form-control"
                            name="identificador"  required
                            autofocus>
                            <input id="pastaatual" type="hidden" value="123" name="pastaatual">
                     </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary ml-2" id="addusuario" type="button">Vincular Usuário</button>
                </div>
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
<script src="{{asset('assets/js/empresa/empresa.js')}}"></script>
<script src="{{asset('assets/js/sistema.js')}}"></script>
<script>
    $(document).ready(function () {
        // zero table
        $('#zero_configuration_table').DataTable({
            "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Portuguese-Brasil.json"
        }
        }); // feature enable/disable
    });
</script>
@endsection
