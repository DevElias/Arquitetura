@extends('layouts.master')
@section('main-content')
<div class="breadcrumb">
    <h1>Aprovação de Usuários em Empresas</h1>
    <ul>
        <li><a href="">Dashboard</a></li>
        <li>Aprovação de Usuários em Empresas</li>
    </ul>
</div>

<div class="separator-breadcrumb border-top"></div>

<div class="row">

<div class="table-responsive">
                                    <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Nome</th>
                                                <th>Email</th>
                                                <th>Empresa</th>
                                                <th>CNPJ</th>
                                                <th>Status</th>
                                                <th>Opções</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($clientes as $cliente): ?>
                                            <tr>
                                                <td><?php echo($cliente->solicitante);?></td>
                                                <td><?php echo($cliente->solicitante_email);?></td>
                                                <td><?php echo($cliente->nome_fantasia);?></td>
                                                <td><?php echo($cliente->cnpj);?></td>
                                                <td>
                                                	<?php if($cliente->solicitacao_status == 0)
                                                          {
                                                    ?>
															<span class="btn btn-warning m-1">Status: Pendente</span>
                       								<?php }
                                                          else{?>
                                 							<span class="btn btn-success m-1">Status: Aprovado</span>
                             						<?php }?>
                                                </td>
                                                <?php if($_SESSION['tipo'] == '0')
                                                      {
                                                 ?>
                                                		<td><a href="#" title="Aprovar" onclick="AprovarSolicitacao(<?php echo($cliente->solicitacao_id);?>);" class="aprovar"><i class="text-20 i-Like"></i></a> <a href="#" title="Reprovar" onclick="ReprovarSolicitacao(<?php echo($cliente->solicitacao_id);?>);" class="reprovar"><i class="text-20 i-Close-Window"></i></a></td>
                                                <?php }else{?>
                                 							<td></td>
                             						<?php }?>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                            	<th>Nome</th>
                                                <th>Email</th>
                                                <th>Empresa</th>
                                                <th>CNPJ</th>
                                                <th>Status</th>
                                                <th>Opções</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
</div>

@endsection

@section('page-js')
<script src="{{asset('assets/js/vendor/echarts.min.js')}}"></script>
<script src="{{asset('assets/js/es5/echart.options.min.js')}}"></script>
<script src="{{asset('assets/js/es5/dashboard.v1.script.js')}}"></script>
<script src="{{asset('assets/js/vendor/datatables.min.js')}}"></script>
<script src="{{asset('assets/js/empresa/empresa.js')}}"></script>
<script src="{{asset('assets/js/jquery-confirm.js')}}"></script>
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
