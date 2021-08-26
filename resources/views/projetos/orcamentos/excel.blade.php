@extends('layouts.master')
@section('main-content')
<div class="breadcrumb">
   <h1 id="nomeprojeto"></h1>
    <ul>
        <li><a href="">Dashboard</a></li>
        <li>Orçamento</li>
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
                        <h2>Relatório Orçamento</h2>
                    </div>
                    <div class="col-12">
                    <div class="table-responsive tabela-custom">
                                        <table class="display table table-striped table-bordered" id="dados-orcamento" style="width:100%">
                                            <thead>

                                                <tr>
                                                    <th>Descrição</th>
                                                    <th>Categoria</th>
                                                    <th>Fornecedor</th>
                                                    <th>Unidade</th>
                                                    <th>Valor Uni.</th>
                                                    <th>Total</th>
                                                    <th>Faturado</th>
                                                    <th>AV</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php foreach($detalhes['itens'] as $value): ?>
                                               <tr>
                                                    <td><?php echo($value->descricao);?></td>
                                                    <td><?php echo($value->nome);?></td>
                                                    <td><?php echo($value->adicionais);?></td>
                                                    <td><?php echo($value->unidade);?></td>
                                                    <td><?php echo(number_format($value->valor, 2, '.', ','));?></td>
                                                    <td><?php echo(number_format($value->total, 2, '.', ','));?></td>
                                                    <td><?php echo($value->faturado);?></td>
                                                    <td><?php echo(round((($value->total / $detalhes['total'][0]->valortotal) * 100), 2));?> %</td>
                                              </tr>
                                            <?php endforeach;  ?>
                                                <tr>
                                                        <td><strong>Total</strong></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td><strong><?php $sum = 0;
                                                        foreach ($detalhes['itens'] as $value){
                                                            $sum += $value->unidade;
                                                        }
                                                        echo($sum); ?></strong></td>
                                                        <td><strong><?php $sum = 0;
                                                        foreach ($detalhes['itens'] as $value){
                                                            $sum += $value->valor;
                                                        }
                                                        echo(number_format($sum, 2, '.', ',')); ?></strong></td>
                                                        <td>
                                                        <strong>
                                                        <?php $sum = 0;
                                                        foreach ($detalhes['itens'] as $value){
                                                            $sum += $value->total;
                                                        }
                                                        echo(number_format($sum, 2, '.', ',')); ?></strong></td>
                                                        <td></td>
                                                        <td><strong>
                                                        <?php
                                                        $sum = 0;
                                                        foreach ($detalhes['itens'] as $value){
                                                            $sum += $value->total;
                                                        }
                                                            echo(round((($sum / $detalhes['total'][0]->valortotal) * 100), 2));?> %
                                                        </strong> </td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>Descrição</th>
                                                    <th>Categoria</th>
                                                    <th>Fornecedor</th>
                                                    <th>Unidade</th>
                                                    <th>Valor Uni.</th>
                                                    <th>Total</th>
                                                    <th>Faturado</th>
                                                    <th>AV</th>
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

@endsection

@section('page-js')
<script src="{{asset('assets/js/vendor/echarts.min.js')}}"></script>
<script src="{{asset('assets/js/es5/echart.options.min.js')}}"></script>
<script src="{{asset('assets/js/es5/dashboard.v1.script.js')}}"></script>
<script src="{{asset('assets/js/vendor/datatables.min.js')}}"></script>
<script src="{{asset('assets/js/jquery.mask.min.js')}}"></script>
<script src="{{asset('assets/js/jquery-confirm.js')}}"></script>
<script src="{{asset('assets/js/sistema.js')}}"></script>
<script src="{{asset('assets/js/projeto/descricao.js')}}"></script>
<script>
    $(document).ready(function () {
        // zero table
        $('#dados-orcamento').DataTable({
            "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Portuguese-Brasil.json"
        },
        dom: 'Bfrtip',
        paging: false,
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
