<?php

namespace App\Http\Controllers;

use App\Cronograma;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\DB;

class CronogramaController extends Controller
{

    public function __construct()
    {
        session_start();
    }

    public function index($id)
    {
        $aCronogramas = DB::table('cronograma')->where('id_projeto', '=', $id)->where('status', '!=', '4')->get();

        return view('projetos.cronograma.cronogramas')->with('cronogramas', $aCronogramas);
    }

    public function detalhe($idProjeto, $idCronograma)
    {
        $aItens = DB::select("SELECT cronograma_item.*, categoria.nome FROM cronograma_item inner join categoria on categoria.id = cronograma_item.id_categoria WHERE cronograma_item.id_cronograma = " . $idCronograma);
        $contador = 0;
        $aTeste = array();

        foreach($aItens as $k=>$v)
        {
            $aTeste[$contador] =  (array) $v;
            $contador++;
        }

        $aCompleto =  $this->agrupar($aTeste, 'id_categoria');

        $aCategorias = DB::table('categoria')->where('categoria.id_vinculos','LIKE','%'.'1'.'%')->where('categoria.status','=','1')->orderBy('categoria.id', 'DESC')->get();

        $data=[
            'categorias'  => $aCategorias,
            'itens'  => $aCompleto,
        ];

        return view('projetos.cronograma.detalhes')->with('detalhes', $data);
    }

    public function create(Request $request)
    {
        $input      = $request->all();
        $cronograma = new Cronograma;
        $i          = 1;

        $cronograma->nome              = $input['nome'];
        $cronograma->status            = $input['status'];
        $cronograma->id_projeto        = $input['idprojeto'];
        $cronograma->data_inclusao     = date('Y-m-d H:i:s');
        $cronograma->usuario_inclusao  = $_SESSION['id'];
        $cronograma->usuario_alteracao = '0';

        try
        {
            $cronograma->save();

            if($cronograma->wasRecentlyCreated == 1)
            {
                $message[] = 'Cronograma cadastrado com sucesso!';
                $code      = 200;
                $redirect  = '';
            }
        }
        catch (Exception $e)
        {
            //$message[] = $e->getMessage();
            $message[] = '';
            $code      = 500;
            $redirect  = '';
        }

        # feedback
        $code = (!empty($code)) ? $code : 200;
        return response(['response' => $message, 'code' => $code, 'redirect' => $redirect]);
    }

    public function createitens(Request $request)
    {
        $input    = $request->all();

        if(isset($input['descricao']))
        {
            $aDados[1]['descricao']    = $input['descricao'];
            $aDados[1]['comeco']       = $input['comeco'];
            $aDados[1]['prancha']       = $input['prancha'];
            $aDados[1]['fim']          = $input['fim'];
            $aDados[1]['executor']     = $input['executor'];
            $aDados[1]['status']       = $input['status'];
            $aDados[1]['categoria']    = $input['categoria'];
            $aDados[1]['cronograma']   = $input['cronograma'];
        }

        if(isset($input['descricao2']))
        {
            $aDados[2]['descricao']  = $input['descricao2'];
            $aDados[2]['prancha']     = $input['prancha2'];
            $aDados[2]['comeco']     = $input['comeco2'];
            $aDados[2]['fim']        = $input['fim2'];
            $aDados[2]['executor']   = $input['executor2'];
            $aDados[2]['status']     = $input['status2'];
            $aDados[2]['categoria']  = $input['categoria'];
            $aDados[2]['cronograma'] = $input['cronograma'];
        }

        if(isset($input['descricao3']))
        {
            $aDados[3]['descricao']  = $input['descricao3'];
            $aDados[3]['prancha']     = $input['prancha3'];
            $aDados[3]['comeco']     = $input['comeco3'];
            $aDados[3]['fim']        = $input['fim3'];
            $aDados[3]['executor']   = $input['executor3'];
            $aDados[3]['status']     = $input['status3'];
            $aDados[3]['categoria']  = $input['categoria'];
            $aDados[3]['cronograma'] = $input['cronograma'];
        }

        if(isset($input['descricao4']))
        {
            $aDados[4]['descricao']  = $input['descricao4'];
            $aDados[4]['prancha']     = $input['prancha4'];
            $aDados[4]['comeco']     = $input['comeco4'];
            $aDados[4]['fim']        = $input['fim4'];
            $aDados[4]['executor']   = $input['executor4'];
            $aDados[4]['status']     = $input['status4'];
            $aDados[4]['categoria']  = $input['categoria'];
            $aDados[4]['cronograma'] = $input['cronograma'];
        }

        if(isset($input['descricao5']))
        {
            $aDados[5]['descricao']  = $input['descricao5'];
            $aDados[5]['prancha']     = $input['prancha5'];
            $aDados[5]['comeco']     = $input['comeco5'];
            $aDados[5]['fim']        = $input['fim5'];
            $aDados[5]['executor']   = $input['executor5'];
            $aDados[5]['status']     = $input['status5'];
            $aDados[5]['categoria']  = $input['categoria'];
            $aDados[5]['cronograma'] = $input['cronograma'];
        }

        for($i=1; $i <= count($aDados); $i++)
        {
            # Inclui os Itens
            $id_cronograma =  DB::table('cronograma_item')->insertGetId([
                'id_cronograma'     => $aDados[$i]['cronograma'],
                'id_categoria'      => $aDados[$i]['categoria'],
                'descricao'         => $aDados[$i]['descricao'],
                'prancha'            => $aDados[$i]['prancha'],
                'inicio'            => $aDados[$i]['comeco'],
                'fim'               => $aDados[$i]['fim'],
                'executor'          => $aDados[$i]['executor'],
                'status'            => $aDados[$i]['status'],
                'usuario_inclusao'  => $_SESSION['id'],
                'data_inclusao'     => date('Y-m-d H:i:s'),
                'usuario_alteracao' =>'0',
            ]);
        }

        if (!empty($id_cronograma))
        {
            $message[] = 'Cronograma criado  com sucesso';
            $code      = 200;
        }
        else
        {
            $message[] = 'Erro ao criar cronograma';
            $code      = 500;
        }

        # feedback
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

    public function destroyitens($id)
    {
        $results = DB::table('cronograma_item')
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

    public function edititens($id)
    {
        $aItem = DB::table('cronograma_item')->where('cronograma_item.id', '=', $id)->get();

        # feedback
        $code = (!empty($code)) ? $code : 200;
        return response()->json(array('response' => $aItem));
    }

    public function updateitens(Request $request)
    {
        $input   = $request->all();

        $results = DB::table('cronograma_item')
        ->where('id', $input['iditem'])
        ->update([
            'id_cronograma'     => $input['editarcronograma'],
            'id_categoria'      => $input['editarcategoria'],
            'descricao'         => $input['editardescricao'],
            'prancha'         => $input['editarprancha'],
            'inicio'            => $input['editarcomeco'],
            'fim'               => $input['editarfim'],
            'executor'          => $input['editarexecutor'],
            'status'            => $input['editarstatus'],
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

    public function update(Request $request)
    {
        $input   = $request->all();

        $results = DB::table('cronograma')
        ->where('id', $input['idcronogramaedit'])
        ->update([
            'nome'         => $input['editcronograma'],
            'status'         => $input['editstatus'],
            'usuario_alteracao' => $_SESSION['id'],
            'data_alteracao'    => date("Y-m-d H:i:s")
        ]);

        if(!empty($results))
        {
            $message[] = 'Cronograma alterado com sucesso!';
            $code = 200;
        }
        else
        {
            $message[] = 'Erro ao tentar alterar Cronograma';
            $code = 500;
        }

        # feedback
        $code = (!empty($code)) ? $code : 200;
        return response(['response' => $message, 'code' => $code]);
    }

    public function busca($id)
    {

        $aCronograma = DB::table('cronograma')->where('id', '=', $id)->get();

        # feedback
        $code = (!empty($code)) ? $code : 200;
        return response(['response' => $aCronograma, 'code' => $code]);
    }

    public function destroy($id)
    {
        //
    }
}
