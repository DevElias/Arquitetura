<?php

namespace App\Http\Controllers;

use App\Financeiro;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\DB;

class FinanceiroController extends Controller
{
    public function __construct()
    {
        session_start();
    }

    public function index()
    {
        return view('projetos.financeiro.home');
    }

    public function agenda($id)
    {
        $aFinanceiro = $aItens = DB::select("SELECT financeiro.*, categoria.nome as categoria FROM financeiro inner join categoria on categoria.id = financeiro.id_categoria WHERE financeiro.id_projeto = " . $id. " ORDER BY  financeiro.dia_pagamento ASC");

        return view('projetos.financeiro.agenda')->with('financeiro', $aFinanceiro);
    }

    public function fluxodecaixa()
    {
        $aFluxodecaixa = $aItens = DB::select("SELECT descricao, id_orcamento, SUM(valor) AS 'Valor', CONCAT(MONTH(STR_TO_DATE(dia_pagamento, '%d/%m/%Y')),'/',  YEAR(STR_TO_DATE(dia_pagamento, '%d/%m/%Y'))) as Dt FROM financeiro WHERE id_projeto = ".$_SESSION['idprojeto']." GROUP BY id_orcamento, dt");
        $contador = 0;
        $aTeste = array();
        $aTestinho = array();

        $somaTotal =$aItens = DB::select("SELECT  SUM(valor) AS 'Valor', id_orcamento    FROM financeiro WHERE id_projeto = ".$_SESSION['idprojeto']." GROUP BY id_orcamento");

        foreach($aFluxodecaixa as $k=>$v)
        {
            $aTeste[$contador] =  (array) $v;
            $contador++;
        }

        $aCompleto =  $this->agrupar($aTeste, 'id_orcamento');

        foreach($aCompleto as $k=>$v)
        {
            $id_orc = $v[0]['id_orcamento'];

            $aCompletinho =  $this->agrupar($v, 'Dt');

            $aTestinho[$id_orc] = $aCompletinho;

        }

        $aDatas =  $this->agrupar($aTeste, 'Dt');

        $datas=[
            'financeiro'  => $aCompleto,
            'datas'       => $aDatas,
            'teste'       => $aTestinho,
            'soma'        => $somaTotal
        ];
        return view('projetos.financeiro.fluxodecaixa')->with('detalhes', $datas);
    }
    public function novo()
    {
        $aCategorias = DB::table('categoria')->where('categoria.id_vinculos','LIKE','%'.'3'.'%')->where('categoria.status','=','1')->orderBy('categoria.id', 'DESC')->get();

        $data=[
            'categorias'  => $aCategorias,
        ];

        return view('projetos.financeiro.novo')->with('detalhes', $data);
    }

    public function novofaturado($projeto, $idorcamento)
    {
        $aItens = DB::select("SELECT orcamento.*, categoria.nome,  categoria.id as id_categ FROM orcamento inner join categoria on categoria.id = orcamento.id_categoria WHERE orcamento.id = ".$idorcamento." AND orcamento.id_projeto =".$_SESSION['idprojeto']);
        $aCategorias = DB::table('categoria')->where('categoria.id_vinculos','LIKE','%'.'3'.'%')->where('categoria.status','=','1')->orderBy('categoria.id', 'DESC')->get();

        $data=[
            'categorias'  => $aCategorias,
            'itens'       => $aItens,
        ];

        return view('projetos.financeiro.novofaturado')->with('detalhes', $data);
    }

    public function create(Request $request)
    {
        $input      = $request->all();
        $financeiro = new Financeiro;
        $parcela    = 1;

        $financeiro->descricao         = $input['descricao'];
        $financeiro->id_categoria      = $input['categoria'];
        $financeiro->dia_pagamento     = $input['data'];
        $financeiro->parcelas          = $input['parcelas'];
        $financeiro->replicar          = $input['replicar'];
        $financeiro->arquivo           = $input['url'];
        $financeiro->status            = $input['status'];
        $financeiro->detalhe           = $input['detalhe'];
        $financeiro->valor             = $input['valor'];
        $financeiro->id_projeto        = $input['idprojeto'];
        $financeiro->data_inclusao     = date('Y-m-d H:i:s');
        $financeiro->usuario_inclusao  = $_SESSION['id'];
        $financeiro->usuario_alteracao = '0';

        try
        {
            for($i=0; $i < $financeiro->parcelas; $i++)
            {
                $texto = '';
                $texto = ' ' .$parcela . '/'. $financeiro->parcelas;

                $financeiro->dia_pagamento = str_replace("/","-",$financeiro->dia_pagamento);
                $descricao = $financeiro->descricao . $texto;

                if($financeiro->replicar == 0)
                {
                    $financeiro->dia_pagamento = $input['data'];
                }
                elseif($financeiro->replicar == 1 && $i != 0)
                {
                    $data = $financeiro->dia_pagamento;
                    $financeiro->dia_pagamento =  date('d/m/Y', strtotime($financeiro->dia_pagamento. ' + 7 days'));
                    $descricao = $financeiro->descricao . $texto;
                }
                elseif($financeiro->replicar == 2 && $i != 0)
                {
                    $data = $financeiro->dia_pagamento;
                    $financeiro->dia_pagamento =  date('d/m/Y', strtotime("+15 days",strtotime($data)));
                    $descricao = $financeiro->descricao . $texto;
                }
                elseif($financeiro->replicar == 3 && $i != 0)
                {
                    $data = $financeiro->dia_pagamento;
                    $financeiro->dia_pagamento =  date('d/m/Y', strtotime("+30 days",strtotime($data)));
                    $descricao = $financeiro->descricao . $texto;
                }

                $financeiro->dia_pagamento = str_replace("-","/",$financeiro->dia_pagamento);

                $aTeste[$i] =$financeiro->dia_pagamento;

                # Registra o Pagamento
                $id_pagamento =  DB::table('financeiro')->insertGetId([
                    'descricao'         => $descricao,
                    'id_categoria'      => $financeiro->id_categoria,
                    'dia_pagamento'     => $financeiro->dia_pagamento,
                    'parcelas'          => $financeiro->parcelas,
                    'replicar'          => $financeiro->replicar,
                    'arquivo'           => $financeiro->arquivo,
                    'status'            => $financeiro->status,
                    'detalhe'           => $financeiro->detalhe,
                    'valor'             => $financeiro->valor,
                    'id_projeto'        => $financeiro->id_projeto,
                    'usuario_inclusao'  => $financeiro->usuario_inclusao,
                    'data_inclusao'     => $financeiro->data_inclusao,
                    'usuario_alteracao' =>'0',
                ]);

                $parcela++;
            }

            if (!empty($id_pagamento))
            {
                $message[] = 'Pagamento cadastrado com sucesso!';
                $code      = 200;
            }
        }
        catch (Exception $e)
        {
            //$message[] = $e->getMessage();
            $message[] = 'Erro ao Cadastrar Financeiro';
            $code      = 500;
        }

        # feedback
        $code = (!empty($code)) ? $code : 200;
        return response(['response' => $message, 'code' => $code]);
    }


    public function createfinanceirorc(Request $request)
    {
        $input      = $request->all();
        $financeiro = new Financeiro;
        $parcela    = 1;

        $financeiro->descricao         = $input['descricao'];
        $financeiro->id_categoria      = $input['categoria'];
        $financeiro->dia_pagamento     = $input['data'];
        $financeiro->parcelas          = $input['parcelas'];
        $financeiro->replicar          = $input['replicar'];
        $financeiro->arquivo           = $input['url'];
        $financeiro->status            = $input['status'];
        $financeiro->detalhe           = $input['detalhe'];
        $financeiro->valor             = $input['valor'];
        $financeiro->id_projeto        = $input['idprojeto'];
        $financeiro->id_orcamento      = $input['idorcamento'];
        $financeiro->data_inclusao     = date('Y-m-d H:i:s');
        $financeiro->usuario_inclusao  = $_SESSION['id'];
        $financeiro->usuario_alteracao = '0';

        try
        {
            for($i=0; $i < $financeiro->parcelas; $i++)
            {
                $texto = '';
                $texto = ' ' .$parcela . '/'. $financeiro->parcelas;

                $financeiro->dia_pagamento = str_replace("/","-",$financeiro->dia_pagamento);
                $descricao = $financeiro->descricao . $texto;

                if($financeiro->replicar == 0)
                {
                    $financeiro->dia_pagamento = $input['data'];
                }
                elseif($financeiro->replicar == 1 && $i != 0)
                {
                    $data = $financeiro->dia_pagamento;
                    $financeiro->dia_pagamento =  date('d/m/Y', strtotime($financeiro->dia_pagamento. ' + 7 days'));
                    $descricao = $financeiro->descricao . $texto;
                }
                elseif($financeiro->replicar == 2 && $i != 0)
                {
                    $data = $financeiro->dia_pagamento;
                    $financeiro->dia_pagamento =  date('d/m/Y', strtotime("+15 days",strtotime($data)));
                    $descricao = $financeiro->descricao . $texto;
                }
                elseif($financeiro->replicar == 3 && $i != 0)
                {
                    $data = $financeiro->dia_pagamento;
                    $financeiro->dia_pagamento =  date('d/m/Y', strtotime("+30 days",strtotime($data)));
                    $descricao = $financeiro->descricao . $texto;
                }

                $financeiro->dia_pagamento = str_replace("-","/",$financeiro->dia_pagamento);

                $aTeste[$i] =$financeiro->dia_pagamento;

                # Registra o Pagamento
                $id_pagamento =  DB::table('financeiro')->insertGetId([
                    'descricao'         => $descricao,
                    'id_categoria'      => $financeiro->id_categoria,
                    'dia_pagamento'     => $financeiro->dia_pagamento,
                    'parcelas'          => $financeiro->parcelas,
                    'replicar'          => $financeiro->replicar,
                    'arquivo'           => $financeiro->arquivo,
                    'status'            => $financeiro->status,
                    'detalhe'           => $financeiro->detalhe,
                    'valor'             => $financeiro->valor,
                    'id_orcamento'      => $financeiro->id_orcamento,
                    'id_projeto'        => $financeiro->id_projeto,
                    'usuario_inclusao'  => $financeiro->usuario_inclusao,
                    'data_inclusao'     => $financeiro->data_inclusao,
                    'usuario_alteracao' =>'0',
                ]);

                $parcela++;
            }

            if (!empty($id_pagamento))
            {
                $id_atualizarocamento = $results = DB::table('orcamento')
                ->where('id', $input['idorcamento'])
                ->update([
                    'faturado'      => 'S',
                    'usuario_alteracao' => $_SESSION['id'],
                    'data_alteracao'    => date("Y-m-d H:i:s")
                ]);
            }


            if (!empty($id_atualizarocamento))
            {
                $message[] = 'Pagamento cadastrado com sucesso!';
                $code      = 200;
            }
        }
        catch (Exception $e)
        {
            //$message[] = $e->getMessage();
            $message[] = 'Erro ao Cadastrar Financeiro';
            $code      = 500;
        }

        # feedback
        $code = (!empty($code)) ? $code : 200;
        return response(['response' => $message, 'code' => $code]);
    }



    public function upload(Request $request)
    {
        $file = $request->file('file');

        $nome     = $file->getClientOriginalName();
        $extensao = $file->getClientOriginalExtension();
        $caminho  = $file->getRealPath();
        $tamanho  = $file->getSize();

        //Move Uploaded File
        $newname = date("dmYHis");
        $destinationPath = base_path('public/financeiro');
        $urlreal         = '/financeiro/'.$newname.'.'.$extensao;
        $file->move($destinationPath,$newname.'.'.$extensao);

        if(!empty($file))
        {
            return response(['dir' => $urlreal, 'name' => $newname.'.'.$extensao]);
        }
    }

    public function listagem($id)
    {
        $aPagamentos = DB::table('financeiro')->where('id_projeto', '=', $id)->get();
        $eventos     = array();

        /*
         *
         {
            title: "Break time",
            start: new Date(year, month, 1),
            allDay: !0,
            color: "#529ef0"
        }
         *
         */

        foreach($aPagamentos as $k=>$v)
        {
            $aData = (explode("/",$v->dia_pagamento));

            $title  = $v->descricao;
            $start  = $aData[2]. ',' . $aData[1] . ',' . $aData[0];
            $allDay = '!0';
            $color  = '#529ef0';

            $eventos[] = [

                'title' => $title,
                'color' => $color,
                'start' => $start,
                'allDay' => $allDay,
            ];

        }

        $Ret = json_encode($eventos);

        echo($Ret);
    }
    public function detalhes($idprojeto, $idpagamento)
    {
        $aPagamento = $aItens = DB::select("SELECT financeiro.*, categoria.nome as categoria FROM financeiro inner join categoria on categoria.id = financeiro.id_categoria WHERE financeiro.id = " . $idpagamento);

        $pagamentos=[
            'pagamento'  => $aPagamento,
        ];
        return view('projetos.financeiro.detalhes')->with('pagamentos', $pagamentos);
    }

    public function editar($idprojeto, $idpagamento)
    {
        $aCategorias = DB::table('categoria')->where('categoria.id_vinculos','LIKE','%'.'3'.'%')->where('categoria.status','=','1')->orderBy('categoria.id', 'DESC')->get();

        $aPagamento = DB::table('financeiro')->where('id', '=', $idpagamento)->get();

        $pagamentos=[
            'pagamento'  => $aPagamento[0],
            'categorias'  => $aCategorias,
        ];

        return view('projetos.financeiro.editar')->with('pagamento', $pagamentos);
    }

    public function destroy(Request $request)
    {
        $input = $request->all();

        $results = DB::table('financeiro')
                ->where('id', $input['id'])
                ->delete();

        if(!empty($results))
        {
            $message[] = 'Pagamento Excluido com Sucesso';
            $code      = 200;
            $redirect = 'http://'.$_SERVER['HTTP_HOST'].'/projeto/'.$_SESSION['idprojeto'].'/financeiro/agenda';
        }
        else
        {
            $message[] = 'Erro ao tentar Excluir Pagamento';
            $code      = 500;
            $redirect = '';
        }

        # feedback
        $code = (!empty($code)) ? $code : 200;
        return response(['response' => $message, 'code' => $code, 'redirect' => $redirect]);
    }


    public function destroyfinanceiroorcamento(Request $request)
    {
        $input = $request->all();

        $results = DB::table('financeiro')
                ->where('id_orcamento', $input['idorcamento'])
                ->delete();

        if(!empty($results))
        {
            $results2 = DB::table('orcamento')
            ->where('id', $input['idorcamento'])
            ->update([
                'faturado'      => 'N',
                'usuario_alteracao' => $_SESSION['id'],
                'data_alteracao'    => date("Y-m-d H:i:s")
            ]);
        }
        if(!empty($results2))
        {
            $idcategoria = DB::select("SELECT id_categoria  FROM orcamento where id = ".$input['idorcamento']." AND id_projeto = ".$_SESSION['idprojeto']);
            $message[] = 'Pagamento Excluido com Sucesso';
            $code      = 200;
            $redirect = 'http://'.$_SERVER['HTTP_HOST'].'/projeto/'.$_SESSION['idprojeto'].'/orcamentos/listagem/?categoria='.$idcategoria[0]->id_categoria;
        }
        else
        {
            $message[] = 'Erro ao tentar Excluir Pagamento';
            $code      = 500;
            $redirect = '';
        }

        # feedback
        $code = (!empty($code)) ? $code : 200;
        return response(['response' => $message, 'code' => $code, 'redirect' => $redirect]);
    }

    public function update(Request $request, $id)
    {
        $input   = $request->all();

        $results = DB::table('financeiro')
        ->where('id', $input['idpagamento'])
        ->update([
            'id_categoria'      => $input['categoria'],
            'dia_pagamento'     => $input['data'],
            'status'            => $input['status'],
            'arquivo'           => $input['url'],
            'valor'             => $input['valor'],
            'detalhe'           => $input['detalhe'],
            'usuario_alteracao' => $_SESSION['id'],
            'data_alteracao'    => date("Y-m-d H:i:s")
        ]);

        if(!empty($results))
        {
            $message[] = 'Pagamento alterado com sucesso!';
            $code = 200;
            $redirect = 'http://'.$_SERVER['HTTP_HOST'].'/projeto/'.$_SESSION['idprojeto'].'/financeiro/agenda';
        }
        else
        {
            $message[] = 'Erro ao tentar alterar Pagamento';
            $code = 500;
            $redirect = '';
        }

        # feedback
        $code = (!empty($code)) ? $code : 200;
        return response(['response' => $message, 'code' => $code, 'redirect' => $redirect]);
    }

    public function agrupar($array, $campoAgrupar)
    {
        $resultado = array();

        foreach($array as $valor)
        {
            $resultado[$valor[$campoAgrupar]][] = $valor;
        }

        return $resultado;
    }
}
