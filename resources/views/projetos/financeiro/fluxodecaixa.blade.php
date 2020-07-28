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
                        <h2>Fluxo de Caixa</h2>
                    </div>
                    <div class="col-12">
                    <div class="table-responsive tabela-custom">
                                        <table class="display table table-striped table-bordered" id="dados-fluxo" style="width:100%">
                                            <thead>

                                                <tr>
                                                    <th>Descrição</th>
                                                    <th>Total</th>
                                                    <?php foreach($detalhes['datas'] as $data):  ?>
                                                    <th><?php echo($data[0]['Dt'])  ?></th>
                                                    <?php endforeach;  ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php foreach($detalhes['teste'] as $financeiros):  ?>
                                               <tr>

                                                <?php
                                                    $x    = 0;
                                                    $desc = '';

                                                    foreach($financeiros as $financeiro)
                                                    {
                                                        if($x == 0)
                                                        {
                                                            $desc = ' <td>'. $financeiro[0]["descricao"]. '</td>';
                                                            $total = '<td> TOTAL </td>';
                                                            $x++;
                                                        }

                                                        foreach($financeiro as $final)
                                                        {
                                                            //Continuar aqui...
                                                            echo('<pre>');
                                                            die(print_r($final, true));
                                                        }
                                                    }

                                                     echo($desc);
                                                     echo($total);
                                                ?>
                                              </tr>
                                            <?php endforeach;  ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                <th>Descrição</th>
                                                <th>Total</th>
                                                <?php foreach($detalhes['datas'] as $data):  ?>
                                                    <th><?php echo($data[0]['Dt'])  ?></th>
                                                <?php endforeach;  ?>
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
        $('#dados-fluxo').DataTable({
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
