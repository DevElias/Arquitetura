@extends('layouts.master')
@section('main-content')
<div class="breadcrumb">
    <h1>Clientes</h1>
    <ul>
        <li><a href="">Dashboard</a></li>
        <li>Dados de Clientes</li>
    </ul>
</div>

<div class="separator-breadcrumb border-top"></div>

<div class="row">
    <div class="table-responsive tabela-custom">
        <table class="display table table-striped table-bordered" id="dados-clientes" style="width:100%">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Telefone</th>
                    <th>Whastapp</th>
                    <th>CPF</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clientes as $cliente): ?>
                    <tr>
                        <td><?php echo($cliente->nome);?></td>
                        <td><?php echo($cliente->email);?></td>
                        <td class="tel"><?php echo($cliente->telefone);?></td>
                        <td class="whats"><?php echo($cliente->whatsapp);?></td>
                        <td class="cpf"><?php echo($cliente->cpf);?></td>
                        <td>
                        <?php if($cliente->status == 0)
                                {
                        ?>
                                <span class="btn btn-warning m-1">Pendente</span>
                        <?php }
                        elseif($cliente->status == 1){?>
                                <span class="btn btn-success m-1">Aprovado</span>
                        <?php }else{?>
                        <span class="btn btn-danger m-1">Reprovado</span>
                        <?php }?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                <th>Nome</th>
                    <th>Email</th>
                    <th>Telefone</th>
                    <th>Whastapp</th>
                    <th>CPF</th>
                    <th>Status</th>
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
<script src="{{asset('assets/js/jquery.mask.min.js')}}"></script>
<script src="{{asset('assets/js/empresa/empresa.js')}}"></script>
<script src="{{asset('assets/js/jquery-confirm.js')}}"></script>
<script src="{{asset('assets/js/sistema.js')}}"></script>
<script>
    $(document).ready(function () {
        // zero table
        $('#dados-clientes').DataTable({
            "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Portuguese-Brasil.json"
        },
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
        }); // feature enable/disable
        setTimeout(
            function()
            {
                $('.buttons-print span').html('Imprimir')
            }, 500);
    });
</script>
@endsection
