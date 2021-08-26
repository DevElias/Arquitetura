@extends('layouts.master')
@section('main-content')
<div class="breadcrumb">
    <h1>Aprovação de Empresas</h1>
    <ul>
        <li><a href="">Dashboard</a></li>
        <li>Aprovação Empresas</li>
    </ul>
</div>

<div class="separator-breadcrumb border-top"></div>

<div class="row">

<div class="table-responsive">
                                    <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Empresa</th>
                                                <th>CNPJ</th>
                                                <th>Respons&aacute;vel</th>
                                                <th>Email</th>
                                                <th>Status</th>
                                                <th>Opções</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                         <?php foreach ($empresas as $empresa): ?>
                                            <tr>
                                                <td><?php echo($empresa->nome_fantasia);?></td>
                                                <td><?php echo($empresa->cnpj);?></td>
                                                <td><?php echo($empresa->nome);?></td>
                                                <td><?php echo($empresa->email);?></td>
                                                <td>
                                                	<?php if($empresa->status == 0)
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
															<td><a href="#" onclick="Aprovar(<?php echo($empresa->id);?>);" class="aprovar"><i title="Aprovar" class="text-20 i-Like"></i></a> <a href="#" onclick="Reprovar(<?php echo($empresa->id);?>);" class="reprovar"><i title="Reprovar" class="text-20 i-Close-Window"></i></a></td>
                       							<?php }else{?>
                                 							<td></td>
                             						<?php }?>
                                            </tr>
                                        <?php endforeach; ?>    
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                            <th>Empresa</th>
                                            <th>CNPJ</th>
                                            <th>Respons&aacute;vel</th>
                                            <th>Email</th>
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
