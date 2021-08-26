<?php

namespace App\Http\Controllers;

use App\Orcamento;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\DB;

class OrcamentosController extends Controller
{

    public function __construct()
    {
        session_start();
    }
    public function index()
    {
        return view('projetos.orcamentos.orcamentos');
    }
    public function orcamentoslistagem($idProjeto){
        $aItens = DB::select("SELECT orcamento.*, categoria.nome FROM orcamento inner join categoria on categoria.id = orcamento.id_categoria WHERE orcamento.status = 1 AND orcamento.id_projeto =".$_SESSION['idprojeto']);
        $contador = 0;
        $aTeste = array();

        foreach($aItens as $k=>$v)
        {
            $aTeste[$contador] =  (array) $v;
            $contador++;
        }

        $aCompleto =  $this->agrupar($aTeste, 'id_categoria');

        $aCategorias = DB::table('categoria')->where('categoria.id_vinculos','LIKE','%'.'2'.'%')->where('categoria.status','=','1')->orderBy('categoria.id', 'DESC')->get();

        $valortotal = DB::select("SELECT sum(total) as valortotal FROM orcamento  WHERE orcamento.status = 1 AND id_projeto = ".$_SESSION['idprojeto']);

        $data=[
            'categorias'  => $aCategorias,
            'itens'  => $aCompleto,
            'total' => $valortotal
        ];

    return view('projetos.orcamentos.listagem')->with('detalhes', $data);
}

public function orcamentosexcel($idProjeto){
    $aCompleto = DB::select("SELECT orcamento.*, categoria.nome FROM orcamento inner join categoria on categoria.id = orcamento.id_categoria WHERE orcamento.status = 1 AND orcamento.id_projeto =".$_SESSION['idprojeto']);
    $contador = 0;


    $valortotal = DB::select("SELECT sum(total) as valortotal FROM orcamento  WHERE orcamento.status = 1 AND id_projeto = ".$_SESSION['idprojeto']);

    $data=[
        'itens'  => $aCompleto,
        'total' => $valortotal
    ];

return view('projetos.orcamentos.excel')->with('detalhes', $data);
}


    public function destroyitens($id)
    {
        $results = DB::table('orcamento')
        ->where('id', $id)
        ->delete();

        if(!empty($results))
        {
            $message[] = 'Item Excluido com Sucesso';
            $code      = 200;
        }
        else
        {
            $message[] = 'Erro ao tentar Excluir Item';
            $code      = 500;
            $redirect  = '';
        }

        # feedback
        $code = (!empty($code)) ? $code : 200;
        return response(['response' => $message, 'code' => $code]);
    }

    public function destroyitenspai($id)
    {
        $results = DB::table('orcamento')
        ->where('id_pai', $id)
        ->delete();

        if(!empty($results))
        {
            $message[] = 'Itens Excluidos com Sucesso';
            $code      = 200;
        }
        else
        {
            $message[] = 'Erro ao tentar Excluir os Itens';
            $code      = 500;
            $redirect  = '';
        }

        # feedback
        $code = (!empty($code)) ? $code : 200;
        return response(['response' => $message, 'code' => $code]);
    }

    public function edititens($id)
    {
        $aItem = DB::table('orcamento')->where('orcamento.id', '=', $id)->get();
        # feedback
        $code = (!empty($code)) ? $code : 200;
        return response()->json(array('response' => $aItem));
    }

    public function updateitens(Request $request)
    {
        $input   = $request->all();

        $results = DB::table('orcamento')
        ->where('id', $input['iditem'])
        ->update([
                'descricao'             => $input['descricao'],
                'unidade'               => $input['unidade'],
                'valor'                 => $input['valorunitario'],
                'total'                 => $input['totaledit'],
                'usuario_alteracao' => $_SESSION['id'],
                'data_alteracao'    => date("Y-m-d H:i:s")
        ]);

        if(!empty($results))
        {
            $message[] = 'Item alterado com sucesso!';
            $code = 200;
        }
        else
        {
            $message[] = 'Erro ao tentar alterar Item';
            $code = 500;
        }

        # feedback
        $code = (!empty($code)) ? $code : 200;
        return response(['response' => $message, 'code' => $code]);

    }


    public function updateitenslote(Request $request)
    {
        $input   = $request->all();
        if(isset($input['idproduto1']))
        {
            $results = DB::table('orcamento')
            ->where('id', $input['idproduto1'])
            ->update([
                    'descricao'                  => $input['descricao1'],
                    'unidade'                    => $input['unidade1'],
                    'valor'                      => str_replace (',', '.', str_replace ('.', '', $input['valorunitario1'])),
                    'total'                      => str_replace (',', '.', str_replace ('.', '', $input['total1'])),
                    'link'                       => $input['link1'],
                    'documento'                  => $input['url1'],
                    'adicionais'                 => $input['adicionais1'],
                    'pergunta'                   => $input['pergunta'],
                    'id_categoria'                  => $input['categoria'],
                    'usuario_alteracao'          => $_SESSION['id'],
                    'data_alteracao'             => date("Y-m-d H:i:s")
            ]);
        }
        if(isset($input['idproduto2']))
        {
            $results = DB::table('orcamento')
            ->where('id', $input['idproduto2'])
            ->update([
                    'descricao'                  => $input['descricao2'],
                    'unidade'                    => $input['unidade2'],
                    'valor'                      => str_replace (',', '.', str_replace ('.', '', $input['valorunitario2'])),
                    'total'                      => str_replace (',', '.', str_replace ('.', '', $input['total2'])),
                    'link'                       => $input['link2'],
                    'documento'                  => $input['url2'],
                    'adicionais'                 => $input['adicionais2'],
                    'pergunta'                   => $input['pergunta'],
                    'id_categoria'                  => $input['categoria'],
                    'usuario_alteracao'          => $_SESSION['id'],
                    'data_alteracao'             => date("Y-m-d H:i:s")
            ]);
        }
        if(isset($input['idproduto3']))
        {
            $results = DB::table('orcamento')
            ->where('id', $input['idproduto3'])
            ->update([
                    'descricao'                  => $input['descricao3'],
                    'unidade'                    => $input['unidade3'],
                    'valor'                      => str_replace (',', '.', str_replace ('.', '', $input['valorunitario3'])),
                    'total'                      => str_replace (',', '.', str_replace ('.', '', $input['total3'])),
                    'link'                       => $input['link3'],
                    'documento'                  => $input['url3'],
                    'adicionais'                 => $input['adicionais3'],
                    'pergunta'                   => $input['pergunta'],
                    'id_categoria'                  => $input['categoria'],
                    'usuario_alteracao'          => $_SESSION['id'],
                    'data_alteracao'             => date("Y-m-d H:i:s")
            ]);
        }
        if(isset($input['idproduto4']))
        {
            $results = DB::table('orcamento')
            ->where('id', $input['idproduto4'])
            ->update([
                    'descricao'                  => $input['descricao4'],
                    'unidade'                    => $input['unidade4'],
                    'valor'                      => str_replace (',', '.', str_replace ('.', '', $input['valorunitario4'])),
                    'total'                      => str_replace (',', '.', str_replace ('.', '', $input['total4'])),
                    'link'                       => $input['link4'],
                    'documento'                  => $input['url4'],
                    'adicionais'                 => $input['adicionais4'],
                    'pergunta'                   => $input['pergunta'],
                    'id_categoria'                  => $input['categoria'],
                    'usuario_alteracao'          => $_SESSION['id'],
                    'data_alteracao'             => date("Y-m-d H:i:s")
            ]);
        }
        if(isset($input['idproduto5']))
        {
            $results = DB::table('orcamento')
            ->where('id', $input['idproduto5'])
            ->update([
                    'descricao'                  => $input['descricao5'],
                    'unidade'                    => $input['unidade5'],
                    'valor'                      => str_replace (',', '.', str_replace ('.', '', $input['valorunitario5'])),
                    'total'                      => str_replace (',', '.', str_replace ('.', '', $input['total5'])),
                    'link'                       => $input['link5'],
                    'documento'                  => $input['url5'],
                    'adicionais'                 => $input['adicionais5'],
                    'pergunta'                   => $input['pergunta'],
                    'id_categoria'                  => $input['categoria'],
                    'usuario_alteracao'          => $_SESSION['id'],
                    'data_alteracao'             => date("Y-m-d H:i:s")
            ]);
        }

        if(!empty($results))
        {
            $message[] = 'Item alterado com sucesso!';
            $code = 200;
        }
        else
        {
            $message[] = 'Erro ao tentar alterar Item';
            $code = 500;
        }

        # feedback
        $code = (!empty($code)) ? $code : 200;
        return response(['response' => $message, 'code' => $code]);

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

    public function orcamentosprodutos($id){

        $aItens = DB::select("SELECT *  FROM orcamento where id_tipo = 0 AND status = 0   and id_projeto = ".$_SESSION['idprojeto']." ORDER BY id_projeto DESC");

            $contador = 0;
            $aTeste = array();

            foreach($aItens as $k=>$v)
            {
                $aTeste[$contador] =  (array) $v;
                $contador++;
            }

            $aItensReprovados = DB::select("SELECT *, orcamento.id as id_orcamento,  categoria.nome  FROM orcamento inner join categoria on categoria.id = orcamento.id_categoria where id_tipo = 0 AND orcamento.status = 2   and id_projeto = ".$_SESSION['idprojeto']." ORDER BY id_projeto DESC");

            $contador = 0;
            $aTeste2 = array();

            foreach($aItensReprovados as $k=>$v)
            {
                $aTeste2[$contador] =  (array) $v;
                $contador++;
            }

            $aAprovadosCompleto = DB::select("SELECT *,  categoria.nome  FROM orcamento inner join categoria on categoria.id = orcamento.id_categoria where id_tipo = 0 AND orcamento.status = 1   and id_projeto = ".$_SESSION['idprojeto']." ORDER BY id_projeto DESC");

            $contador = 0;
            $aTeste3 = array();

            foreach($aAprovadosCompleto as $k=>$v)
            {
                $aTeste3[$contador] =  (array) $v;
                $contador++;
            }

            $aCompleto =  $this->agrupar($aTeste, 'id_pai');
            $aReprovadoCompleto =  $this->agrupar($aTeste2, 'id_categoria');
            $aAprovadosCompleto =  $this->agrupar($aTeste3, 'id_categoria');
            $data=[
                'itens'  => $aCompleto,
                'itensreprovados'  => $aReprovadoCompleto,
                'itensaprovados'  => $aAprovadosCompleto,
            ];

        return view('projetos.orcamentos.produtos')->with('detalhes', $data);

    }
    public function orcamentosprodutosnovo(){
        $aCategorias = DB::table('categoria')->where('categoria.id_vinculos','LIKE','%'.'2'.'%')->where('categoria.status','=','1')->orderBy('categoria.id', 'DESC')->get();

        $data=[
            'categorias'  => $aCategorias,
        ];

        return view('projetos.orcamentos.produtosnovo')->with('detalhes', $data);
    }
    public function orcamentosservicosnovo(){
        $aCategorias = DB::table('categoria')->where('categoria.id_vinculos','LIKE','%'.'2'.'%')->where('categoria.status','=','1')->orderBy('categoria.id', 'DESC')->get();

        $data=[
            'categorias'  => $aCategorias,
        ];

        return view('projetos.orcamentos.servicosnovo')->with('detalhes', $data);
    }
    public function orcamentosservicos($id){

        $aItens = DB::select("SELECT *  FROM orcamento where id_tipo = 1 AND status = 0   and id_projeto = ".$_SESSION['idprojeto']." ORDER BY id_projeto DESC");

            $contador = 0;
            $aTeste = array();

            foreach($aItens as $k=>$v)
            {
                $aTeste[$contador] =  (array) $v;
                $contador++;
            }

            $aItensReprovados = DB::select("SELECT *,  categoria.nome  FROM orcamento inner join categoria on categoria.id = orcamento.id_categoria where id_tipo = 1 AND orcamento.status = 2   and id_projeto = ".$_SESSION['idprojeto']." ORDER BY id_projeto DESC");

            $contador = 0;
            $aTeste2 = array();

            foreach($aItensReprovados as $k=>$v)
            {
                $aTeste2[$contador] =  (array) $v;
                $contador++;
            }

            $aAprovadosCompleto = DB::select("SELECT *,  categoria.nome  FROM orcamento inner join categoria on categoria.id = orcamento.id_categoria where id_tipo = 1 AND orcamento.status = 1   and id_projeto = ".$_SESSION['idprojeto']." ORDER BY id_projeto DESC");

            $contador = 0;
            $aTeste3 = array();

            foreach($aAprovadosCompleto as $k=>$v)
            {
                $aTeste3[$contador] =  (array) $v;
                $contador++;
            }

            $aCompleto =  $this->agrupar($aTeste, 'id_pai');
            $aReprovadoCompleto =  $this->agrupar($aTeste2, 'id_pai');
            $aAprovadosCompleto =  $this->agrupar($aTeste3, 'id_pai');
            $data=[
                'itens'  => $aCompleto,
                'itensreprovados'  => $aReprovadoCompleto,
                'itensaprovados'  => $aAprovadosCompleto,
            ];

        return view('projetos.orcamentos.servicos')->with('detalhes', $data);
    }
    public function createproduto(Request $request)
    {
        $input = $request->all();

        if(isset($input['descricao']))
        {
            $aDados[1]['descricao']             = $input['descricao'];
            $aDados[1]['id_categoria']          = $input['categoria'];
            $aDados[1]['pergunta']              = $input['pergunta'];
            $aDados[1]['unidade']               = $input['unidade'];
            $aDados[1]['valor']                 = str_replace (',', '.', str_replace ('.', '', $input['valorunitario']));
            $aDados[1]['total']                 = str_replace (',', '.', str_replace ('.', '', $input['total']));
            $aDados[1]['link']                  = $input['link'];
            $aDados[1]['url']                   = $input['url'];
            $aDados[1]['adicionais']            = $input['adicionais'];
        }
        if(isset($input['descricao2']))
        {
            $aDados[2]['descricao']             = $input['descricao2'];
            $aDados[2]['id_categoria']          = $input['categoria'];
            $aDados[2]['pergunta']              = $input['pergunta'];
            $aDados[2]['unidade']               = $input['unidade2'];
            $aDados[2]['valor']                 = str_replace (',', '.', str_replace ('.', '', $input['valorunitario2']));
            $aDados[2]['total']                 = str_replace (',', '.', str_replace ('.', '', $input['total2']));
            $aDados[2]['link']                  = $input['link2'];
            $aDados[2]['url']                   = $input['url2'];
            $aDados[2]['adicionais']            = $input['adicionais2'];
        }
        if(isset($input['descricao3']))
        {
            $aDados[3]['descricao']             = $input['descricao3'];
            $aDados[3]['id_categoria']          = $input['categoria'];
            $aDados[3]['pergunta']              = $input['pergunta'];
            $aDados[3]['unidade']               = $input['unidade3'];
            $aDados[3]['valor']                 = str_replace (',', '.', str_replace ('.', '', $input['valorunitario3']));
            $aDados[3]['total']                 = str_replace (',', '.', str_replace ('.', '', $input['total3']));
            $aDados[3]['link']                  = $input['link3'];
            $aDados[3]['url']                   = $input['url3'];
            $aDados[3]['adicionais']            = $input['adicionais3'];
        }
        if(isset($input['descricao4']))
        {
            $aDados[4]['descricao']             = $input['descricao4'];
            $aDados[4]['id_categoria']          = $input['categoria'];
            $aDados[4]['pergunta']              = $input['pergunta'];
            $aDados[4]['unidade']               = $input['unidade4'];
            $aDados[4]['valor']                 = str_replace (',', '.', str_replace ('.', '', $input['valorunitario4']));
            $aDados[4]['total']                 = str_replace (',', '.', str_replace ('.', '', $input['total4']));
            $aDados[4]['link']                  = $input['link4'];
            $aDados[4]['url']                   = $input['url4'];
            $aDados[4]['adicionais']            = $input['adicionais4'];
        }
        if(isset($input['descricao5']))
        {
            $aDados[5]['descricao']             = $input['descricao5'];
            $aDados[5]['id_categoria']          = $input['categoria'];
            $aDados[5]['pergunta']              = $input['pergunta'];
            $aDados[5]['unidade']               = $input['unidade5'];
            $aDados[5]['valor']                 = str_replace (',', '.', str_replace ('.', '', $input['valorunitario5']));
            $aDados[5]['total']                 = str_replace (',', '.', str_replace ('.', '', $input['total5']));
            $aDados[5]['link']                  = $input['link5'];
            $aDados[5]['url']                   = $input['url5'];
            $aDados[5]['adicionais']            = $input['adicionais5'];
        }
        $token = openssl_random_pseudo_bytes(4);
        $token = bin2hex($token);
        $newsdate = date('His');
        $idpai = $newsdate.$token;
        for($i=1; $i <= count($aDados); $i++)
        {
            # Inclui os Itens
            $id_orcamento =  DB::table('orcamento')->insertGetId([
                'id_categoria'          => $input['categoria'],
                'id_pai'                => $idpai,
                'id_tipo'                => '0',
                'pergunta'              => $aDados[$i]['pergunta'],
                'descricao'             => $aDados[$i]['descricao'],
                'unidade'               => $aDados[$i]['unidade'],
                'valor'                 => $aDados[$i]['valor'],
                'total'                 => $aDados[$i]['total'],
                'link'                  => $aDados[$i]['link'],
                'documento'             => $aDados[$i]['url'],
                'adicionais'            => $aDados[$i]['adicionais'],
                'status'                =>'0',
                'motivo'                => '',
                'id_projeto'            => $input['idprojeto'],
                'usuario_inclusao'      => $_SESSION['id'],
                'data_inclusao'         => date('Y-m-d H:i:s'),
                'usuario_alteracao'     =>'0',
            ]);
        }


        if (!empty($id_orcamento))
        {
            $message[] = 'Cadastro de itens para Aprovação feito com sucesso!';
            $code      = 200;
        }
        else
        {
            $message[] = 'Erro ao criar itens para Aprovação';
            $code      = 500;
        }

        # feedback
        return response(['response' => $message, 'code' => $code]);
    }


    public function createservico(Request $request)
    {
        $input = $request->all();

        if(isset($input['descricao']))
        {
            $aDados[1]['descricao']             = $input['descricao'];
            $aDados[1]['id_categoria']          = $input['categoria'];
            $aDados[1]['pergunta']              = $input['pergunta'];
            $aDados[1]['unidade']               = $input['unidade'];
            $aDados[1]['valor']                 = str_replace (',', '.', str_replace ('.', '', $input['valorunitario']));
            $aDados[1]['total']                 = str_replace (',', '.', str_replace ('.', '', $input['total']));
            $aDados[1]['link']                  = $input['link'];
            $aDados[1]['adicionais']            = $input['adicionais'];
        }
        if(isset($input['descricao2']))
        {
            $aDados[2]['descricao']             = $input['descricao2'];
            $aDados[2]['id_categoria']          = $input['categoria'];
            $aDados[2]['pergunta']              = $input['pergunta'];
            $aDados[2]['unidade']               = str_replace (',', '.', str_replace ('.', '', $input['valorunitario2']));
            $aDados[2]['valor']                 = str_replace (',', '.', str_replace ('.', '', $input['total2']));
            $aDados[2]['total']                 = $input['total2'];
            $aDados[2]['link']                  = $input['link2'];
            $aDados[2]['adicionais']            = $input['adicionais2'];
        }
        if(isset($input['descricao3']))
        {
            $aDados[3]['descricao']             = $input['descricao3'];
            $aDados[3]['id_categoria']          = $input['categoria'];
            $aDados[3]['pergunta']              = $input['pergunta'];
            $aDados[3]['unidade']               = $input['unidade3'];
            $aDados[3]['valor']                 = str_replace (',', '.', str_replace ('.', '', $input['valorunitario3']));
            $aDados[3]['total']                 = str_replace (',', '.', str_replace ('.', '', $input['total3']));
            $aDados[3]['link']                  = $input['link3'];
            $aDados[3]['adicionais']            = $input['adicionais3'];
        }
        if(isset($input['descricao4']))
        {
            $aDados[4]['descricao']             = $input['descricao4'];
            $aDados[4]['id_categoria']          = $input['categoria'];
            $aDados[4]['pergunta']              = $input['pergunta'];
            $aDados[4]['unidade']               = $input['unidade4'];
            $aDados[4]['valor']                 = str_replace (',', '.', str_replace ('.', '', $input['valorunitario4']));
            $aDados[4]['total']                 = str_replace (',', '.', str_replace ('.', '', $input['total4']));
            $aDados[4]['link']                  = $input['link4'];
            $aDados[4]['adicionais']            = $input['adicionais4'];
        }
        if(isset($input['descricao5']))
        {
            $aDados[5]['descricao']             = $input['descricao5'];
            $aDados[5]['id_categoria']          = $input['categoria'];
            $aDados[5]['pergunta']              = $input['pergunta'];
            $aDados[5]['unidade']               = $input['unidade5'];
            $aDados[5]['valor']                 = str_replace (',', '.', str_replace ('.', '', $input['valorunitario5']));
            $aDados[5]['total']                 = str_replace (',', '.', str_replace ('.', '', $input['total5']));
            $aDados[5]['link']                  = $input['link5'];
            $aDados[5]['adicionais']            = $input['adicionais5'];
        }
        $token = openssl_random_pseudo_bytes(4);
        $token = bin2hex($token);
        $idpai = date('His').$token;
        for($i=1; $i <= count($aDados); $i++)
        {
            # Inclui os Itens
            $id_orcamento =  DB::table('orcamento')->insertGetId([
                'id_categoria'          => $input['categoria'],
                'id_pai'                => $idpai,
                'id_tipo'                => '1',
                'pergunta'              => $aDados[$i]['pergunta'],
                'descricao'             => $aDados[$i]['descricao'],
                'unidade'               => $aDados[$i]['unidade'],
                'valor'                 => $aDados[$i]['valor'],
                'total'                 => $aDados[$i]['total'],
                'link'                  => $aDados[$i]['link'],
                'documento'             => '',
                'adicionais'            => $aDados[$i]['adicionais'],
                'status'                =>'0',
                'motivo'                => '',
                'id_projeto'            => $input['idprojeto'],
                'usuario_inclusao'      => $_SESSION['id'],
                'data_inclusao'         => date('Y-m-d H:i:s'),
                'usuario_alteracao'     =>'0',
            ]);
        }


        if (!empty($id_orcamento))
        {
            $message[] = 'Cadastro de itens para Aprovação feito com sucesso!';
            $code      = 200;
        }
        else
        {
            $message[] = 'Erro ao criar itens para Aprovação';
            $code      = 500;
        }

        # feedback
        return response(['response' => $message, 'code' => $code]);
    }


    public function itemaprovado(Request $request)
    {
        $input = $request->all();


        if(isset($input['descricao']))
        {
            $aDados[1]['descricao']             = $input['descricao'];
            $aDados[1]['id_categoria']          = $input['categoria'];
            $aDados[1]['unidade']               = $input['unidade'];

            $unitario1 = str_replace(".","",$input['valorunitario']);
            $unitario1 = str_replace(",",".",$unitario1);

            $total1    = str_replace(".","",$input['total']);
            $total1    = str_replace(",",".",$total1);

            $aDados[1]['valor']                 = $unitario1;
            $aDados[1]['total']                 = $total1;
        }
        if(isset($input['descricao2']))
        {
            $aDados[2]['descricao']             = $input['descricao2'];
            $aDados[2]['id_categoria']          = $input['categoria'];
            $aDados[2]['unidade']               = $input['unidade2'];

            $unitario2 = str_replace(".","",$input['valorunitario2']);
            $unitario2 = str_replace(",",".",$unitario2);

            $total2    = str_replace(".","",$input['total2']);
            $total2    = str_replace(",",".",$total2);


            $aDados[2]['valor']                 = $unitario2;
            $aDados[2]['total']                 = $total2;
        }
        if(isset($input['descricao3']))
        {
            $aDados[3]['descricao']             = $input['descricao3'];
            $aDados[3]['id_categoria']          = $input['categoria'];
            $aDados[3]['unidade']               = $input['unidade3'];

            $unitario3 = str_replace(".","",$input['valorunitario3']);
            $unitario3 = str_replace(",",".",$unitario3);

            $total3    = str_replace(".","",$input['total3']);
            $total3    = str_replace(",",".",$total3);

            $aDados[3]['valor']                 = $unitario3;
            $aDados[3]['total']                 = $total3;
        }
        if(isset($input['descricao4']))
        {
            $aDados[4]['descricao']             = $input['descricao4'];
            $aDados[4]['id_categoria']          = $input['categoria'];
            $aDados[4]['unidade']               = $input['unidade4'];

            $unitario4 = str_replace(".","",$input['valorunitario4']);
            $unitario4 = str_replace(",",".",$unitario4);

            $total4    = str_replace(".","",$input['total4']);
            $total4    = str_replace(",",".",$total4);

            $aDados[4]['valor']                 = $unitario4;
            $aDados[4]['total']                 = $total4;
        }
        if(isset($input['descricao5']))
        {
            $aDados[5]['descricao']             = $input['descricao5'];
            $aDados[5]['id_categoria']          = $input['categoria'];
            $aDados[5]['unidade']               = $input['unidade5'];

            $unitario5 = str_replace(".","",$input['valorunitario5']);
            $unitario5 = str_replace(",",".",$unitario5);

            $total5    = str_replace(".","",$input['total5']);
            $total5    = str_replace(",",".",$total5);

            $aDados[5]['valor']                 = $unitario5;
            $aDados[5]['total']                 = $total5;
        }

        for($i=1; $i <= count($aDados); $i++)
        {
            # Inclui os Itens
            $id_orcamento =  DB::table('orcamento')->insertGetId([
                'id_categoria'          => $input['categoria'],
                'id_pai'                => '',
                'id_tipo'                => '2',
                'pergunta'              => '',
                'descricao'             => $aDados[$i]['descricao'],
                'unidade'               => $aDados[$i]['unidade'],
                'valor'                 => $aDados[$i]['valor'],
                'total'                 => $aDados[$i]['total'],
                'link'                  => '',
                'documento'             => '',
                'adicionais'            => '',
                'status'                =>'1',
                'motivo'                => '',
                'id_projeto'            => $input['idprojeto'],
                'usuario_inclusao'      => $_SESSION['id'],
                'data_inclusao'         => date('Y-m-d H:i:s'),
                'usuario_alteracao'     =>'0',
            ]);
        }


        if (!empty($id_orcamento))
        {
            $message[] = 'Iten(s) cadastrado com sucesso!';
            $code      = 200;
        }
        else
        {
            $message[] = 'Erro ao criar o(s) itens!';
            $code      = 500;
        }

        # feedback
        return response(['response' => $message, 'code' => $code]);
    }

    public function imagemorcamento(Request $request)
    {
        $file = $request->file('file');

        $nome     = $file->getClientOriginalName();
        $extensao = $file->getClientOriginalExtension();
        $caminho  = $file->getRealPath();
        $tamanho  = $file->getSize();

        //Move Uploaded File
        $newname = date("dmYHis");
        $urlreal         = '/orcamento/'.$newname.'.'.$extensao;
        $destinationPath = base_path('public_html/orcamento');
        $file->move($destinationPath,$newname.'.'.$extensao);

        if(!empty($file))
        {
            return response(['dir' => $urlreal, 'name' => $newname.'.'.$extensao]);
        }
    }

    public function aprovarProduto(Request $request)
    {
        $input = $request->all();
        $idescolhido = $input['form'][0]['value'];
        $idpai = $input['id_pai'];

        $results = DB::table('orcamento')
        ->where('id', $idescolhido)
        ->update([
                'status'             => '1',
                'usuario_alteracao' => $_SESSION['id'],
                'data_alteracao'    => date("Y-m-d H:i:s")
        ]);


        $results2 = DB::table('orcamento')
        ->where('id_pai', $idpai)
        ->where('id','!=', $idescolhido)
        ->update([
                'status'             => '2',
                'usuario_alteracao' => $_SESSION['id'],
                'data_alteracao'    => date("Y-m-d H:i:s")
        ]);

        if (!empty($results))
        {
            $message[] = 'Item Aprovado com Sucesso!';
            $code      = 200;
        }
        else
        {
            $message[] = 'Erro ao aprovar o item!';
            $code      = 500;
        }

        # feedback
        return response(['response' => $message, 'code' => $code]);
    }

    public function reprovarProduto(Request $request)
    {
        $input   = $request->all();
        $results = DB::table('orcamento')
        ->where('id_pai', $input['idpai'])
        ->update([
                'motivo'             => $input['motivo'],
                'status'             => '2',
                'usuario_alteracao' => $_SESSION['id'],
                'data_alteracao'    => date("Y-m-d H:i:s")
        ]);

        if(!empty($results))
        {
            $message[] = 'Item Reprovado com Sucesso!';
            $code = 200;
        }
        else
        {
            $message[] = 'Erro ao Reprovar o Item';
            $code = 500;
        }

        # feedback
        $code = (!empty($code)) ? $code : 200;
        return response(['response' => $message, 'code' => $code]);

    }

    public function updatePergProdutos($idprojeto, $idpai){
        $aCategorias = DB::table('categoria')->where('categoria.id_vinculos','LIKE','%'.'2'.'%')->where('categoria.status','=','1')->orderBy('categoria.id', 'DESC')->get();

        $aProdutos = DB::table('orcamento')->where('id_pai', '=', $idpai)->get();

        $itens=[
            'produtos'  => $aProdutos,
            'categorias'  => $aCategorias,
        ];

        return view('projetos.orcamentos.produtoseditar')->with('itens', $itens);
    }


    public function updatePergServicos($idprojeto, $idpai){
        $aCategorias = DB::table('categoria')->where('categoria.id_vinculos','LIKE','%'.'2'.'%')->where('categoria.status','=','1')->orderBy('categoria.id', 'DESC')->get();

        $aProdutos = DB::table('orcamento')->where('id_pai', '=', $idpai)->get();

        $itens=[
            'produtos'  => $aProdutos,
            'categorias'  => $aCategorias,
        ];

        return view('projetos.orcamentos.servicoseditar')->with('itens', $itens);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
