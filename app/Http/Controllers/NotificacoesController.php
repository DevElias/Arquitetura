<?php

namespace App\Http\Controllers;

use App\Notificacoes;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\DB;

class NotificacoesController extends Controller
{
    public function __construct()
    {
        session_start();
    }

    public function index()
    {
        $aCategorias = DB::table('categoria')->where('categoria.id_vinculos','LIKE','%'.'5'.'%')->where('categoria.status','=','1')->orderBy('categoria.id', 'DESC')->get();

        $aNotificacoes = DB::select("SELECT notificacoes.*, categoria.nome FROM notificacoes inner join categoria on categoria.id = notificacoes.id_categoria AND id_projeto =" .$_SESSION['idprojeto']);
        $contador = 0;
        $aTeste = array();

        foreach($aNotificacoes as $k=>$v)
        {
            $aTeste[$contador] =  (array) $v;
            $contador++;
        }

        $aCompleto =  $this->agrupar($aTeste, 'id_categoria');

        $data=[
            'categorias'  => $aCategorias,
            'itens'  => $aCompleto,
        ];


        return view('projetos.notificacoes.notificacoes')->with('detalhes', $data);
    }

    public function novo()
    {
        $aCategorias = DB::table('categoria')->where('categoria.id_vinculos','LIKE','%'.'5'.'%')->where('categoria.status','=','1')->orderBy('categoria.id', 'DESC')->get();

        $data=[
            'categorias'  => $aCategorias,
        ];

        return view('projetos.notificacoes.novo')->with('detalhes', $data);
    }

    public function create(Request $request)
    {
        $input = $request->all();
        $notificacoes = new Notificacoes;

        $notificacoes->descricao         = $input['descricao'];
        $notificacoes->id_categoria      = $input['categoria'];
        $notificacoes->arquivo           = $input['url'];
        if($input['documento'] != ""):
        $notificacoes->documento         = $input['documento'];
        endif;
        if($input['prancha'] != ""):
        $notificacoes->prancha           = $input['prancha'];
        endif;
        if($input['escala'] != ""):
        $notificacoes->escala            = $input['escala'];
        endif;
        $notificacoes->status            = $input['status'];
        $notificacoes->previsto          = $input['previsto'];
        if($input['link'] != ""):
        $notificacoes->link              = $input['link'];
        endif;
        if($input['detalhe'] != ""):
        $notificacoes->detalhe           = $input['detalhe'];
        endif;
        $notificacoes->id_projeto        = $input['idprojeto'];
        $notificacoes->data_inclusao     = date('Y-m-d H:i:s');
        $notificacoes->usuario_inclusao  = $_SESSION['id'];
        $notificacoes->usuario_alteracao = '0';

        try
        {
            $notificacoes->save();

            if($notificacoes->wasRecentlyCreated == 1)
            {
                $message[] = 'Notificação cadastrada com sucesso!';
                $code      = 200;
                $redirect  = '';
            }
        }
        catch (Exception $e)
        {
            //$message[] = $e->getMessage();
            $message[] = 'Erro ao Cadastrar Notificação';
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
        $destinationPath = base_path('public/notificacoes');
        $urlreal         = '/notificacoes/'.$newname.'.'.$extensao;
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

    public function edit($idprojeto, $idnotificacao)
    {
        $aCategorias = DB::table('categoria')->where('categoria.id_vinculos','LIKE','%'.'5'.'%')->where('categoria.status','=','1')->orderBy('categoria.id', 'DESC')->get();

        $aNotificacoes = DB::table('notificacoes')->where('id', '=', $idnotificacao)->get();

        $data=[
            'notificacoes'  => $aNotificacoes[0],
            'categorias'  => $aCategorias,
        ];

        return view('projetos.notificacoes.editar')->with('detalhes', $data);
    }

    public function update(Request $request, $id)
    {
        $input   = $request->all();

        $results = DB::table('notificacoes')
        ->where('id', $input['idnotificacao'])
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
            $message[] = 'Notificação alterada com sucesso!';
            $code = 200;
            $redirect = 'http://'.$_SERVER['HTTP_HOST'].'/projeto/'.$_SESSION['idprojeto'].'/notificacoes';
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
        $results = DB::table('notificacoes')
        ->where('id', $id)
        ->delete();

        if(!empty($results))
        {
            $message[] = 'Notificação Excluida com Sucesso';
            $code      = 200;
        }
        else
        {
            $message[] = 'Erro ao tentar Excluir Notificação';
            $code      = 500;
            $redirect  = '';
        }

        # feedback
        $code = (!empty($code)) ? $code : 200;
        return response(['response' => $message, 'code' => $code]);
    }
}
