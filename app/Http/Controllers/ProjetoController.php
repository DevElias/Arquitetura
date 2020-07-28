<?php

namespace App\Http\Controllers;

use App\Projeto;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\DB;

class ProjetoController extends Controller
{

    public function __construct()
    {
        session_start();
    }

    public function index()
    {
        if($_SESSION['tipo'] == 0){
            $aProjetos = DB::table('projeto')->where('status', '!=', '4')->get();
        }else {
            $aProjetos = DB::select("SELECT projeto.* FROM projeto inner join solicitacao on solicitacao.id_projeto = projeto.id where solicitacao.id_usuario = " . $_SESSION['id']);

        }


        return view('projetos.projeto')->with('projetos', $aProjetos);
    }

    public function create(Request $request)
    {
        $input   = $request->all();
        $projeto = new Projeto;

        $projeto->nome  = $input['nome'];
        $projeto->descricao      = $input['descricao'];
        $projeto->cep            = $input['cep'];
        $projeto->endereco       = $input['endereco'];
        $projeto->numero         = $input['numero'];
        $projeto->complemento    = $input['complemento'];
        $projeto->bairro         = $input['bairro'];
        $projeto->cidade         = $input['cidade'];
        $projeto->estado         = $input['estado'];
        $projeto->id_responsavel = '0';
        $projeto->status         = $input['status'];
        $projeto->etapa          = $input['etapa'];
        $projeto->data_inclusao     = date('Y-m-d H:i:s');
        $projeto->usuario_inclusao  = $_SESSION['id'];
        $projeto->usuario_alteracao = '0';

        try
        {
            $projeto->save();

            if($projeto->wasRecentlyCreated == 1)
            {
                $message[] = 'Projeto cadastrado com sucesso!';
                $code      = 200;
                $redirect  = '/projeto';
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

    public function search(Request $request)
    {
        $input = $request->all();

        $aProjetos = array();
        $html      = '';

        $aProjetos = DB::table('projeto')->where('nome','LIKE','%'.$input['projeto'].'%')->get();

        if($aProjetos->isNotEmpty())
        {
            $code = 200;
            $html  = '';

            # Montagem Front PROJETOS
            for($i=0; $i < count($aProjetos); $i++)
            {
                $html .= '<div class="col-md-3">';
                $html .= '<div class="card mb-4">';
                if($aProjetos[$i]->status == 1)
                {
                    $html .= '<a href="/projeto/'.$aProjetos[$i]->id . '/my-drive" class="card-body text-center">';
                }
                else
                {
                    $html .= '<a href="/projeto/'.$aProjetos[$i]->id . '/status" class="card-body text-center">';
                }
                $html .= '<h2 class="mb-3"><span class="subtitulo-projeto">Projeto</span> <br />'.$aProjetos[$i]->nome.'</h2>';
                if($aProjetos[$i]->etapa == 0)
                {
                    $status = '<span class="btn btn-warning m-1">Status: Briefing</span>';
                }
                elseif($aProjetos[$i]->etapa == 1)
                {
                    $status = '<span class="btn btn-success m-1">Status: Projeto</span>';
                }
                elseif($aProjetos[$i]->etapa == 2)
                {
                    $status = '<span class="btn btn-success m-1">Status: Planejamento</span>';
                }
                elseif($aProjetos[$i]->etapa == 3)
                {
                    $status = '<span class="btn btn-success m-1">Status: Obra</span>';
                }
                elseif($aProjetos[$i]->etapa == 4)
                {
                    $status = '<span class="btn btn-success m-1">Status: Produção</span>';
                }

                $html .=  $status;
                $html .= '<hr>';
                $html .= '<p>Endere&ccedil;o: '.$aProjetos[$i]->endereco . ' '. $aProjetos[$i]->numero . ' - ' . $aProjetos[$i]->cidade .'</p>';
                $html .= '</a>';
                $html .= '</div>';
                $html .= '</div>';
            }
        }
        else
        {
            $code = 500;
        }

        # feedback
        $code = (!empty($code)) ? $code : 200;
        return response()->json(array('response' => true, 'html'=>$html));
    }

    public function show($id)
    {
        $_SESSION['idprojeto'] = $id;
        $aProjeto = DB::table('projeto')->where('projeto.id', '=', $id)->get();

        $aSolcitacao = DB::select("SELECT * FROM solicitacao inner join usuario on usuario.id = solicitacao.id_usuario where solicitacao.id_projeto = '" . $id . "'");

        $data=[
            'projeto'  => $aProjeto[0],
            'usuarios' => $aSolcitacao,
        ];

        return view('projetos.status')->with('detalhes', $data);
    }

    public function get(Request $request)
    {
        $input = $request->all();

        $aProjeto = DB::table('projeto')->where('projeto.id', '=', $input['idprojeto'])->get();

        # feedback
        $code = (!empty($code)) ? $code : 200;
        return response(['code' => $code, 'projeto' => $aProjeto[0]]);
    }

    public function edit($id)
    {
        $aProjeto = DB::table('projeto')->where('projeto.id', '=', $id)->get();

        $data=[
            'projeto'  => $aProjeto[0],
        ];

        return view('projetos.editar')->with('detalhes', $data);
    }


    public function update(Request $request, $id)
    {
        $input = $request->all();

        $results = DB::table('projeto')
        ->where('id', $input['idprojeto'])
        ->update([
            'nome'              => $input['nome'],
            'descricao'         => $input['descricao'],
            'cep'               => $input['cep'],
            'endereco'          => $input['endereco'],
            'numero'            => $input['numero'],
            'complemento'       => $input['complemento'],
            'bairro'            => $input['bairro'],
            'estado'            => $input['estado'],
            'etapa'             => $input['etapa'],
            'status'            => $input['status'],
            'usuario_alteracao' => $_SESSION['id'],
            'data_alteracao'    => date("Y-m-d H:i:s")
        ]);

        if(!empty($results))
        {
            $message[] = 'Projeto atualizado com Sucesso';
            $code      = 200;
            $redirect  = 'http://'.$_SERVER['HTTP_HOST'].'/projeto/'.$_SESSION['idprojeto'].'/status';
        }
        else
        {
            $message[] = 'Erro ao tentar atualizar Projeto';
            $code      = 500;
            $redirect  = '';
        }

        # feedback
        $code = (!empty($code)) ? $code : 200;
        return response(['response' => $message, 'code' => $code, 'redirect' => $redirect]);
    }

    public function destroy($id)
    {
        //
    }
}
