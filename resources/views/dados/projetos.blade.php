@extends('layouts.master')
@section('main-content')
<div class="breadcrumb">
    <h1>Projetos</h1>
    <ul>
        <li><a href="">Dashboard</a></li>
        <li>Dados de Projetos</li>
    </ul>
</div>

<div class="separator-breadcrumb border-top"></div>

<div class="row">
    <div class="table-responsive tabela-custom">
        <table class="display table table-striped table-bordered" id="dados-clientes" style="width:100%">
            <thead>
                <tr>
                    <th>Nome do Projeto</th>
                    <th>Endereço</th>
                    <th>Numero</th>
                    <th>Cep</th>
                    <th>Bairro</th>
                    <th>Cidade</th>
                    <th>Estado</th>
                    <th>Etapa</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($projetos as $projeto): ?>
                    <tr>
                        <td><?php echo($projeto->nome);?></td>
                        <td><?php echo($projeto->endereco);?></td>
                        <td><?php echo($projeto->numero);?></td>
                        <td><?php echo($projeto->cep);?></td>
                        <td><?php echo($projeto->bairro);?></td>
                        <td><?php echo($projeto->cidade);?></td>
                        <td><?php echo($projeto->estado);?></td>
                        <td>
                            <?php if($projeto->etapa == 0)
                                    {
                            ?>
                                    <span class="btn btn-warning m-1">Briefing</span>
                            <?php }
                            elseif($empresa->status == 1){?>
                                    <span class="btn btn-success m-1">Projeto</span>
                            <?php }elseif($empresa->status == 2){?>
                                    <span class="btn btn-success m-1">Planejamento</span>
                            <?php }elseif($empresa->status == 3){?>
                                    <span class="btn btn-success m-1">Obra</span>
                            <?php }elseif($empresa->status == 4){?>
                                    <span class="btn btn-success m-1">Produção</span>
                            <?php } ?>
                        </td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                <th>Nome do Projeto</th>
                    <th>Endereço</th>
                    <th>Numero</th>
                    <th>Cep</th>
                    <th>Bairro</th>
                    <th>Cidade</th>
                    <th>Estado</th>
                    <th>Etapa</th>
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
