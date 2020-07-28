<?php

namespace App\Http\Controllers;

use App\Anexos;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\DB;

class AnexosController extends Controller
{
    public function __construct()
    {
        session_start();
    }

    public function index()
    {
        $aCategorias = DB::table('categoria')->where('categoria.id_vinculos','LIKE','%'.'6'.'%')->where('categoria.status','=','1')->orderBy('categoria.id', 'DESC')->get();

        $aAnexos = DB::select("SELECT anexos.*, categoria.nome FROM anexos inner join categoria on categoria.id = anexos.id_categoria AND id_projeto =" .$_SESSION['idprojeto']);
        $contador = 0;
        $aTeste = array();

        foreach($aAnexos as $k=>$v)
        {
            $aTeste[$contador] =  (array) $v;
            $contador++;
        }

        $aCompleto =  $this->agrupar($aTeste, 'id_categoria');

        $data=[
            'categorias'  => $aCategorias,
            'itens'  => $aCompleto,
        ];


        return view('projetos.anexos.anexos')->with('detalhes', $data);
    }

    public function create(Request $request)
    {
        $input = $request->all();
        $anexo = new Anexos;

        $anexo->descricao         = $input['descricao'];
        $anexo->id_categoria      = $input['categoria'];
        $anexo->arquivo           = $input['url'];
        if($input['documento'] != ""):
        $anexo->documento         = $input['documento'];
        endif;
        if($input['prancha'] != ""):
        $anexo->prancha           = $input['prancha'];
        endif;
        if($input['escala'] != ""):
        $anexo->escala            = $input['escala'];
        endif;
        $anexo->status            = $input['status'];
        $anexo->previsto          = $input['previsto'];
        if($input['link'] != ""):
        $anexo->link              = $input['link'];
        endif;
        if($input['detalhe'] != ""):
        $anexo->detalhe           = $input['detalhe'];
        endif;
        $anexo->id_projeto        = $input['idprojeto'];
        $anexo->data_inclusao     = date('Y-m-d H:i:s');
        $anexo->usuario_inclusao  = $_SESSION['id'];
        $anexo->usuario_alteracao = '0';

        try
        {
            $anexo->save();

            if($anexo->wasRecentlyCreated == 1)
            {
                $message[] = 'Projeto cadastrado com sucesso!';
                $code      = 200;
                $redirect  = '';
            }
        }
        catch (Exception $e)
        {
            //$message[] = $e->getMessage();
            $message[] = 'Erro ao Cadastrar Projeto';
            $code      = 500;
            $redirect  = '';
        }

        # feedback
        $code = (!empty($code)) ? $code : 200;
        return response(['response' => $message, 'code' => $code, 'redirect' => $redirect]);
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
        $destinationPath = base_path('public/anexo');
        $urlreal         = '/anexo/'.$newname.'.'.$extensao;
        $file->move($destinationPath,$newname.'.'.$extensao);

        if(!empty($file))
        {
            return response(['dir' => $urlreal, 'name' => $newname.'.'.$extensao]);
        }
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

    public function edit($idprojeto, $idanexo)
    {
        $aCategorias = DB::table('categoria')->where('categoria.id_vinculos','LIKE','%'.'6'.'%')->where('categoria.status','=','1')->orderBy('categoria.id', 'DESC')->get();

        $aAnexo = DB::table('anexos')->where('id', '=', $idanexo)->get();

        $data=[
            'anexo'  => $aAnexo[0],
            'categorias'  => $aCategorias,
        ];

        return view('projetos.anexos.editar')->with('detalhes', $data);
    }

    public function update(Request $request, $id)
    {
        $input   = $request->all();

        $results = DB::table('anexos')
        ->where('id', $input['idanexo'])
        ->update([
            'descricao'         => $input['descricao'],
            'id_categoria'      => $input['categoria'],
            'arquivo'           => $input['url'],
            'documento'         => $input['documento'],
            'prancha'           => $input['prancha'],
            'escala'            => $input['escala'],
            'status'            => $input['status'],
            'previsto'          => $input['previsto'],
            'link'              => $input['link'],
            'detalhe'           => $input['detalhe'],
            'usuario_alteracao' => $_SESSION['id'],
            'data_alteracao'    => date("Y-m-d H:i:s")
        ]);

        if(!empty($results))
        {
            $message[] = 'Projeto alterado com sucesso!';
            $code = 200;
            $redirect = 'http://'.$_SERVER['HTTP_HOST'].'/projeto/'.$_SESSION['idprojeto'].'/anexos';
        }
        else
        {
            $message[] = 'Erro ao tentar alterar Projeto';
            $code = 500;
            $redirect = '';
        }

        # feedback
        $code = (!empty($code)) ? $code : 200;
        return response(['response' => $message, 'code' => $code, 'redirect' => $redirect]);
    }

    public function destroy($id)
    {
        $results = DB::table('anexos')
        ->where('id', $id)
        ->delete();

        if(!empty($results))
        {
            $message[] = 'Projeto Excluido com Sucesso';
            $code      = 200;
        }
        else
        {
            $message[] = 'Erro ao tentar Excluir Projeto';
            $code      = 500;
            $redirect  = '';
        }

        # feedback
        $code = (!empty($code)) ? $code : 200;
        return response(['response' => $message, 'code' => $code]);
    }

    public function novo()
    {
        $aCategorias = DB::table('categoria')->where('categoria.id_vinculos','LIKE','%'.'6'.'%')->where('categoria.status','=','1')->orderBy('categoria.id', 'DESC')->get();

        $data=[
            'categorias'  => $aCategorias,
        ];

        return view('projetos.anexos.novo')->with('detalhes', $data);
    }
}
