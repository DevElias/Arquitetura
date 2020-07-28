<?php

namespace App\Http\Controllers;

use App\Pasta;
use App\Empresa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\DB;

class EmpresaController extends Controller
{
    public function __construct()
    {
        session_start();
    }

    public function index()
    {
        $aEmpresas = array();

        # Administrador
        if($_SESSION['tipo'] == '0')
        {
            $aEmpresas = DB::table('empresa')->join('usuario', 'usuario.id', '=', 'empresa.id_responsavel')->where('empresa.status', '!=', '2')->get(['empresa.*','usuario.nome']);

            return view('empresa.empresa')->with('empresas', $aEmpresas);
        }
        else
        {
            #empresas que o usuario comum tem acesso
            $aEmpresas = DB::select('SELECT
                                        empresa.id as id,
                                        empresa.nome_fantasia as nome_fantasia,
                                        empresa.status as status,
                                        empresa.cnpj as cnpj,
                                        empresa.endereco as endereco,
                                        empresa.numero as numero,
                                        empresa.cidade as cidade,
                                        responsavel.nome as nome
                                     FROM solicitacao
                                         INNER JOIN empresa ON empresa.id = solicitacao.id_empresa
                                         INNER JOIN usuario responsavel ON responsavel.id = empresa.id_responsavel
                                     WHERE solicitacao.id_usuario = '. $_SESSION['id'] . ' AND empresa.status != 2');

            //$aEmpresas = DB::table('empresa')->where('empresa.usuario_inclusao', '=', $_SESSION['id'])->join('usuario', 'usuario.id', '=', 'empresa.id_responsavel')->get(['empresa.*','usuario.nome']);
            return view('empresa.empresa')->with('empresas', $aEmpresas);
        }
    }

    public function create(Request $request)
    {
        $input   = $request->all();
        $empresa = new Empresa;

        $empresa->nome_fantasia  = $request->fantasia;
        $empresa->razao_social   = $request->social;
        $empresa->cnpj           = $request->cnpj;
        $empresa->email          = $request->email;
        $empresa->telefone       = $request->tel;
        $empresa->whatsapp       = $request->whats;
        $empresa->cep            = $request->cep;
        $empresa->endereco       = $request->endereco;
        $empresa->numero         = $request->numero;
        $empresa->complemento    = $request->complemento;
        $empresa->bairro         = $request->bairro;
        $empresa->cidade         = $request->cidade;
        $empresa->estado         = $request->estado;
        $empresa->segmento       = $request->segmento;
        $empresa->id_responsavel = $_SESSION['id'];

        # Administrador
        if($_SESSION['tipo'] == '0')
        {
            $empresa->status         = '1'; // Aprovada
        }
        else
        {
            $empresa->status         = '0'; // Pendente
        }

        $empresa->data_inclusao     = date('Y-m-d H:i:s');
        $empresa->usuario_inclusao  = $_SESSION['id'];
        $empresa->usuario_alteracao = '0';

        try
        {
            $empresa->save();

            if($empresa->wasRecentlyCreated == 1)
            {
                $message[] = 'Empresa cadastrada com sucesso!';
                $code      = 200;
                $redirect  = '/empresa';

                # Envia notificacao do usuario comum ao adm
                if($_SESSION['tipo'] != '0')
                {
                    $administrador =  DB::select("SELECT * FROM usuario WHERE usuario.tipo_usuario = 0");

                    $id_notificacao =  DB::table('notificacao')->insertGetId([
                                       'id_usuario_envia' => $_SESSION['id'],
                                       'id_usuario_recebe' => $administrador[0]->id,
                                       'mensagem' => 'Usuario, '. $_SESSION['nome']. ', criou uma empresa e esta pendente de aprovacao',
                                       'status' => 0,
                                       'data_notificacao' => date("Y-m-d H:i:s")
                    ]);

                    #Cria solicitacao de aprovacao para empresa
                    $id_solicitacao =  DB::table('solicitacao')->insertGetId([
                        'id_usuario' => $_SESSION['id'],
                        'id_empresa' => $empresa->id,
                        'status' => 0,
                        'data_solicitacao' => date("Y-m-d H:i:s")
                    ]);
                }
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

        $aEmpresas = array();
        $html = '';
        if($_SESSION['tipo'] == 0)
        {
            $aEmpresas = DB::table('empresa')->where('nome_fantasia','LIKE','%'.$input['empresa'].'%')->get();
        }
        else
        {
            $aEmpresas = DB::table('empresa')->where('nome_fantasia','LIKE','%'.$input['empresa'].'%')->where('usuario_inclusao','=',$_SESSION['id'])->get();
        }

        if($aEmpresas->isNotEmpty())
        {
            $code = 200;
            $html  = '';

            # Montagem Front Empresas
            for($i=0; $i < count($aEmpresas); $i++)
            {
                $html .= '<div class="col-md-3">';
                $html .= '<div class="card mb-4">';
                if($aEmpresas[$i]->status == 1)
                {
                    $html .= '<a href="/empresa/'.$aEmpresas[$i]->id . '/my-drive" class="card-body text-center">';
                }
                else
                {
                    $html .= '<a href="#" class="card-body text-center">';
                }
                $html .= '<h2 class="mb-3">'.$aEmpresas[$i]->nome_fantasia.'</h2>';
                if($aEmpresas[$i]->status == 0)
                {
                    $status = '<p><span class="btn btn-warning m-1">Status: Pendente</span></p>';
                }
                elseif($aEmpresas[$i]->status == 1)
                {
                    $status = '<p><span class="btn btn-success m-1">Status: Aprovado</span></p>';
                }
                else
                {
                    $status = '<p><span class="btn btn-danger m-1">Status: Reprovado</span></p>';
                }
                $html .=  $status;
                $html .= '<h3>CNPJ: '.$aEmpresas[$i]->cnpj .'</h3>';
                $html .= '<p>Endere&ccedil;o: '.$aEmpresas[$i]->endereco . ' '. $aEmpresas[$i]->numero . ' - ' . $aEmpresas[$i]->cidade .'</p>';
                $html .= '<hr>';
                $html .= '<h4>Respons&aacute;vel: '.$aEmpresas[$i]->id_responsavel . '</h4>';
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

    public function aprovacoes()
    {
        $aEmpresas = array();

        # Administrador
        if($_SESSION['tipo'] == '0')
        {
            $aEmpresas = DB::table('empresa')->join('usuario', 'usuario.id', '=', 'empresa.id_responsavel')->where('empresa.status', '=', '0')->get(['empresa.*','usuario.nome']);
            return view('aprovacoes.empresas')->with('empresas', $aEmpresas);
        }
        else
        {
            $aEmpresas = DB::table('empresa')->join('usuario', 'usuario.id', '=', 'empresa.id_responsavel')->where('empresa.usuario_inclusao', '=', $_SESSION['id'])->where('empresa.status', '=', '0')->get(['empresa.*','usuario.nome']);
            return view('aprovacoes.empresas')->with('empresas', $aEmpresas);
        }
    }

    public function aprovar(Request $request)
    {
        $input = $request->all();

        $results = DB::table('empresa')
                   ->where('id', $input['id'])
                   ->update(['status' => '1']);

        #verificar se empresa foi criada por usuario comum
        $aEmpresa = DB::table('empresa')->find($input['id']);

        #verifica se o responsavel que criou a empresa e diferente do cara que esta aprovando neste caso o adm
        if($aEmpresa->id_responsavel != $_SESSION['id'])
        {
            $aSolicitacao = DB::select("SELECT * FROM solicitacao WHERE solicitacao.id_usuario = ".$aEmpresa->id_responsavel . ' and solicitacao.id_empresa = ' . $input['id']);

            if(!empty($aSolicitacao))
            {
                $results = DB::table('solicitacao')
                           ->where('id', $aSolicitacao[0]->id)
                           ->update(['status' => '1']);
            }
        }

        # Envia notificacao para quem solicitou aprovacao da empresa
        $aprovador =  DB::select("SELECT * FROM usuario WHERE usuario.tipo_usuario = ". $_SESSION['id']);

        $id_notificacao =  DB::table('notificacao')->insertGetId([
            'id_usuario_envia' => $_SESSION['id'],
            'id_usuario_recebe' => $aSolicitacao[0]->id_usuario,
            'mensagem' => 'Usuario, '. $_SESSION['nome']. ', aprovou a sua solicitacao de criacao da empresa '. $aEmpresa->razao_social,
            'status' => 0,
            'data_notificacao' => date("Y-m-d H:i:s")
        ]);

        $message[] = 'Empresa aprovada com sucesso!';
        $code = 200;
        $redirect = '/aprovacoes/empresas';

        # feedback
        $code = (!empty($code)) ? $code : 200;
        return response(['response' => $message, 'code' => $code, 'redirect' => $redirect]);
    }

    public function reprovar(Request $request)
    {
        $input = $request->all();

        $results = DB::table('empresa')
                    ->where('id', $input['id'])
                    ->update(['status' => '2']);

        #verificar se empresa foi criada por usuario comum
        $aEmpresa = DB::table('empresa')->find($input['id']);

        #verifica se o responsavel que criou a empresa e diferente do cara que esta reprovando neste caso o adm
        if($aEmpresa->id_responsavel != $_SESSION['id'])
        {
            $aSolicitacao = DB::select("SELECT * FROM solicitacao WHERE solicitacao.id_usuario = ".$aEmpresa->id_responsavel . ' and solicitacao.id_empresa = ' . $input['id']);

            if(!empty($aSolicitacao))
            {
                $results = DB::table('solicitacao')
                ->where('id', $aSolicitacao[0]->id)
                ->update(['status' => '2']);
            }
        }

        # Envia notificacao para quem solicitou aprovacao da empresa, informando que a empresa foi reprovada
        $aprovador =  DB::select("SELECT * FROM usuario WHERE usuario.tipo_usuario = ". $_SESSION['id']);

        $id_notificacao =  DB::table('notificacao')->insertGetId([
            'id_usuario_envia' => $_SESSION['id'],
            'id_usuario_recebe' => $aSolicitacao[0]->id_usuario,
            'mensagem' => 'Usuario, '. $_SESSION['nome']. ', reprovou a sua solicitacao de criacao da empresa '. $aEmpresa->razao_social,
            'status' => 0,
            'data_notificacao' => date("Y-m-d H:i:s")
        ]);

        $message[] = 'Empresa reprovada com sucesso!';
        $code = 200;
        $redirect = '/aprovacoes/empresas';

        # feedback
        $code = (!empty($code)) ? $code : 200;
        return response(['response' => $message, 'code' => $code, 'redirect' => $redirect]);
    }

    public function conteudo($id)
    {
        $aPermissao = DB::table('solicitacao')->where('solicitacao.id_empresa', '=', $id)->where('solicitacao.id_usuario', '=', $_SESSION['id'])->where('solicitacao.status', '=', 1)->get();

        # Nao permite o usuario burlar o sistema pela URL
        if($_SESSION['tipo'] != '0')
        {
            if($aPermissao->isEmpty())
            {
                header("Location: /404");
                die();
            }
        }

        # pasta com id da empresa
        $diretorio = base_path('public/conteudo/'.$id);
        #conteudo
        $dir2 = base_path('public/conteudo');
        if(!file_exists($dir2))
        {
            mkdir(base_path('public/conteudo/', 0777, true));
        }

        #Verifica se existe o diretorio, se nao cria
        if(!file_exists($diretorio))
        {
            mkdir(base_path('public/conteudo/'.$id, 0777, true));
            mkdir(base_path('public/conteudo/'.$id.'/my-drive', 0777, true));
        }

        #grid de usuarios que solicitaram vinculo com a empresa, aprovados ou pendentes
        $aSolicitacoes = DB::select('SELECT
                                       solicitacao.id AS solicitacao_id,
                                       solicitacao.status as solicitacao_status,
                                       solicitante.id AS solicitante_id,
                                       solicitante.nome AS solicitante,
                                       solicitante.email AS solicitante_email,
                                       empresa.id as empresa_id,
                                       empresa.*,
                                       responsavel.nome AS responsavel
                                     FROM solicitacao
                                       INNER JOIN usuario solicitante ON solicitante.id = solicitacao.id_usuario
                                       INNER JOIN empresa ON empresa.id = solicitacao.id_empresa
                                       INNER JOIN usuario responsavel ON responsavel.id = empresa.id_responsavel
                                     WHERE solicitacao.id_empresa = '.$id);

        #Efetuar Leitura do DB de pastas e arquivos
        $aDados['conteudo'] = DB::table('pasta')->get()->where('id_empresa', '=', $id)->where('extend_random', '=', '');
        $aDados['info']     = DB::table('empresa')->find($id);
        $aDados['solicitacoes'] = $aSolicitacoes;

        return view('empresa.empresa-dados')->with('dados', $aDados);
    }

    public function status($id){
        return view('projetos.status');
    }
    public function cronogramas($id){
        return view('projetos.cronogramas');
    }
    public function cronogramasdetalhes($id2){
        return view('projetos.detalhes');
    }
    public function orcamentos($id2){
        return view('projetos.orcamentos.orcamentos');
    }
    public function orcamentoslistagem($id2){
        return view('projetos.orcamentos.listagem');
    }
    public function orcamentosprodutos($id2){
        return view('projetos.orcamentos.produtos');
    }
    public function orcamentosservicos($id2){
        return view('projetos.orcamentos.serviços');
    }



    public function criarpasta(Request $request)
    {
        $input   = $request->all();

        $pasta   = new Pasta;
        $caminho = str_replace("empresa","conteudo",$input['pathname']);

        # verifica se e pasta pai ou filho
        $pos = strpos($input['pathname'], 'folders' );
        # Remove espacos em branco e caracteres especiais por causa do servidor linux
        //$cPasta = str_replace(" ","_",$input['descricao']);
        $cPasta = $input['descricao'];
        $cPasta = preg_replace("/[^a-zA-Z0-9\_\-]+/", "", $cPasta);
        $cPasta = $cPasta . date("dmYHis");

        if(!$pos)
        {
            $pasta->extend_random = '';
            mkdir(base_path('public/'.$caminho.'/'.$cPasta, 0777, true));

            $pasta->url         = 'public'.$caminho.'/'.$cPasta;
            $pasta->breadcrumbs = $caminho.'/'.$input['descricao'];
        }
        else
        {
            $url = explode('/',$input['pathname']);
            $pasta->extend_random = $url['4'];
            # Se for Pasta verifica Diretorio Pai
            $cDir       = Pasta::where('id_random',$url['4'])->get();
            $pasta->url = $cDir[0]->url.'/'.$cPasta;
            $pasta->breadcrumbs = $cDir[0]->breadcrumbs.'/'.$input['descricao'];
            mkdir(base_path($cDir[0]->url.'/'.$cPasta, 0777, true));
        }

        #Grava pasta no DB
        $token = openssl_random_pseudo_bytes(14);
        $hex   = bin2hex($token);

        $pasta->descricao  = $input['descricao'];
        $pasta->tipo       = 0; // Pasta
        $pasta->id_random  = $hex;
        $pasta->id_empresa = $input['idempresa'];

        try
        {
            $pasta->save();

            if($pasta->wasRecentlyCreated == 1)
            {
                $message[] = 'Pasta criada com sucesso!';
                $code      = 200;
            }
        }
        catch (Exception $e)
        {
            $message[] = $e->getMessage();
            $code      = 500;
        }

        # feedback
        $code = (!empty($code)) ? $code : 200;
        return response(['response' => $message, 'code' => $code]);
    }

    public function pasta($id, $pasta)
    {
        $aDados['conteudo'] = DB::table('pasta')->where('extend_random', '=', $pasta)->get();

        #Breadcrumbs
        $aDados['breadcrumbs'] = DB::table('pasta')->where('id_random', '=', $pasta)->get();
        $aBreadcrumbs = explode('/',$aDados['breadcrumbs'][0]->breadcrumbs);

        #Limpa ate a raiz
        unset($aBreadcrumbs[0]);
        unset($aBreadcrumbs[1]);
        unset($aBreadcrumbs[2]);
        unset($aBreadcrumbs[3]);
        $aDados['breadcrumbs']   = $aBreadcrumbs;

        $aDados['info'] = DB::table('empresa')->find($id);
        return view('empresa.empresa-dados')->with('dados', $aDados);
    }

    public function arquivo(Request $request)
    {
       //dd($request);

       $pasta     = new Pasta;
       $file      = $request->file;
       $descricao = $request->descricao;
       $id        = $request->empresa;
       $url       = $request->urlatual;

       $nome     = $file->getClientOriginalName();
       $extensao = $file->getClientOriginalExtension();
       $caminho  = $file->getRealPath();
       $tamanho  = $file->getSize();

       # verifica se e pasta pai ou filho
       $pos     = strpos($url, 'folders' );
       $partes  = explode('/',$url);
       $newname = date("dmYHis");

       if(!$pos)
       {
           $path = 'conteudo/'.$partes[2].'/'.$partes[3]. '/'.$newname;
           //Move Uploaded File
           $destinationPath = base_path('public/conteudo/'.$id.'/my-drive');
           $file->move($destinationPath,$newname.'.'.$extensao);
          // rename($file->getClientOriginalName() , $newname);

           $pasta->extend_random = '';
           $pasta->url           = $path.'.'.$extensao;
           $pasta->breadcrumbs = '';
       }
       else
       {
           $diretorio = explode('/',$url);
           $pasta->extend_random = $diretorio['4'];
           $aDir = DB::table('pasta')->where('id_random', '=', $diretorio['4'])->get();
           $partes = explode('/',$aDir[0]->url);
           $idempresa = $partes[2];

           unset($partes[0]); // public
           unset($partes[1]); // conteudo
           unset($partes[2]); // id_empresa
           unset($partes[3]); // my-drive

           /* $i = 0
            * count($partes) = 4
            * $j = 4;
            */
           $j = 4;
           $cURL = '';

           for($i=0; $i < count($partes); $i++)
           {
               $cURL = $cURL . '/'.$partes[$j];
               $j++;
           }

           $path       = 'conteudo/'.$idempresa.'/my-drive'.$cURL. '/' .$newname;
           $pasta->url = $path.'.'.$extensao;
           $pasta->breadcrumbs = '';

           //Move Uploaded File
           $destinationPath = base_path($aDir[0]->url);
           $file->move($destinationPath,$newname.'.'.$extensao);
       }

       #Grava arquivo no DB
       $token = openssl_random_pseudo_bytes(14);
       $hex   = bin2hex($token);

       $pasta->descricao  = $nome;
       $pasta->tipo       = 1; // Arquivo
       $pasta->id_random  = $hex;
       $pasta->id_empresa = $id;

       try
       {
           $pasta->save();

           if($pasta->wasRecentlyCreated == 1)
           {
               $message[] = 'Arquivo gravado com sucesso!';
               $code      = 200;
           }
       }
       catch (Exception $e)
       {
           $message[] = $e->getMessage();
           $code      = 500;
       }

       header("Location: " . $url);
       die();
    }

    public function solicitar(Request $request)
    {
        $empresa = new Empresa;
        $input   = $request->all();

        # Nao administrador
        if($_SESSION['tipo'] != '0')
        {
            $aDados  = Empresa::where('cnpj', '=', $input['cnpj'])->get();

            if($aDados->isNotEmpty())
            {
                if($aDados[0]->status == 1)
                {
                    # Verifica se o usuario ja solicitou vinculo com a empresa anteriormente
                    # Talvez no futuro precise implementar o where solicitacao.status != 2 para solicitacoes rejeitadas
                    $aSolicitacoes  = DB::select("SELECT * FROM solicitacao WHERE solicitacao.id_usuario = ".$_SESSION['id'] . ' and solicitacao.id_empresa =' . $aDados[0]->id);

                    if(empty($aSolicitacoes))
                    {
                        $id_solicitacao =  DB::table('solicitacao')->insertGetId([
                            'id_usuario' => $_SESSION['id'],
                            'id_empresa' => $aDados[0]->id,
                            'status' => 0,
                            'data_solicitacao' => date("Y-m-d H:i:s")
                        ]);

                        if(!empty($id_solicitacao))
                        {
                            $message[] = 'Solicitacao enviada com sucesso!';
                            $code      = 200;
                            $redirect  = '/empresa/vinculo';

                            # Envia notificacao do usuario comum ao adm
                            if($_SESSION['tipo'] != '0')
                            {
                                $administrador =  DB::select("SELECT * FROM usuario WHERE usuario.tipo_usuario = 0");

                                $id_notificacao =  DB::table('notificacao')->insertGetId([
                                    'id_usuario_envia' => $_SESSION['id'],
                                    'id_usuario_recebe' => $administrador[0]->id,
                                    'mensagem' => 'Usuario, '. $_SESSION['nome']. ', solicitou acesso a empresa '. $aDados[0]->razao_social. '',
                                    'status' => 0,
                                    'data_notificacao' => date("Y-m-d H:i:s")
                                ]);
                            }
                        }
                        else
                        {
                            $message[] = 'Erro ao efetuar vinculo';
                            $code = 500;
                            $redirect  = '';
                        }
                    }
                    else
                    {
                        $message[] = 'Erro ao solicitar v&iacute;nculo, pois j&aacute; existe uma solicita&ccedil;&atilde;o para essa empresa';
                        $code = 500;
                        $redirect  = '';
                    }
                }
                else
                {
                    $message[] = 'Status da Empresa Pendente de Aprova&ccedil;&atilde;o pelo administrador';
                    $code      = 200;
                    $redirect  = '/empresa/vinculo';
                }
            }
            else
            {
                $message[] = 'CNPJ n&atilde;o localizado';
                $code      = 200;
                $redirect  = '';
            }
        }
        else
        {
            $message[] = 'Administradores n&atilde;o podem solicitar v&iacute;nculos com empresa';
            $code      = 200;
            $redirect  = '';
        }

        # feedback
        $code = (!empty($code)) ? $code : 200;
        return response(['response' => $message, 'code' => $code, 'redirect' => $redirect]);
    }

    public function listagem()
    {
        $aEmpresas = array();

        # Administrador
        if($_SESSION['tipo'] == '0')
        {
            $aSolicitacoes = DB::table('solicitacao')->join('empresa', 'solicitacao.id_empresa', '=', 'empresa.id')
                                                     ->join('usuario', 'empresa.id_responsavel', '=', 'usuario.id')
                                                     ->where('solicitacao.status', '=', 0)
                                                     ->get(['empresa.*','solicitacao.status','usuario.nome']);
        }
        else
        {
            $aSolicitacoes = DB::table('solicitacao')->join('empresa', 'solicitacao.id_empresa', '=', 'empresa.id')
                                                     ->join('usuario', 'empresa.id_responsavel', '=', 'usuario.id')
                                                     ->where('solicitacao.id_usuario', '=', $_SESSION['id'])
                                                     ->where('solicitacao.status', '=', 0)
                                                     ->get(['empresa.*','solicitacao.status','usuario.nome']);
        }

        return view('empresa.vinculo')->with('soicitacoes', $aSolicitacoes);
    }

    public function aprovacliente()
    {
        $aEmpresas = array();

        # Administrador
        if($_SESSION['tipo'] == '0')
        {
            $aSolicitacoes = DB::select('SELECT
                                                        solicitacao.id AS solicitacao_id,
                                                        solicitacao.status as solicitacao_status,
                                                        solicitante.nome AS solicitante,
                                                        solicitante.email AS solicitante_email,
                                                        empresa.*,
                                                        responsavel.nome AS responsavel
                                                      FROM solicitacao
                                                        INNER JOIN usuario solicitante ON solicitante.id = solicitacao.id_usuario
                                                        INNER JOIN empresa ON empresa.id = solicitacao.id_empresa
                                                        INNER JOIN usuario responsavel ON responsavel.id = empresa.id_responsavel
                                                      WHERE solicitacao.status = 0');
        }
        else
        {
            $aSolicitacoes = DB::select('SELECT
                                                        solicitacao.id AS solicitacao_id,
                                                        solicitacao.status as solicitacao_status,
                                                        solicitante.nome AS solicitante,
                                                        solicitante.email AS solicitante_email,
                                                        empresa.*,
                                                        responsavel.nome AS responsavel
                                                      FROM solicitacao
                                                        INNER JOIN usuario solicitante ON solicitante.id = solicitacao.id_usuario
                                                        INNER JOIN empresa ON empresa.id = solicitacao.id_empresa
                                                        INNER JOIN usuario responsavel ON responsavel.id = empresa.id_responsavel
                                                      WHERE solicitacao.status = 0 and solicitacao.id_usuario = '. $_SESSION['id']);
        }

        return view('aprovacoes.clientes')->with('clientes', $aSolicitacoes);
    }

    public function aprovarsolicitacao(Request $request)
    {
        $input = $request->all();

        $results = DB::table('solicitacao')
        ->where('id', $input['id_solicitacao'])
        ->update(['status' => '1']);

        if(!empty($results))
        {
            $message[] = 'Solicita&ccedil;&atilde;o aprovada com sucesso!';
            $code = 200;
        }
        else
        {
            $message[] = 'Erro ao tentar aprovar solicita&ccedil;&atilde;o';
            $code = 500;
        }

        # feedback
        $code = (!empty($code)) ? $code : 200;
        return response(['response' => $message, 'code' => $code]);
    }

    public function reprovarsolicitacao(Request $request)
    {
        $input = $request->all();

        $results = DB::table('solicitacao')
        ->where('id', $input['id_solicitacao'])
        ->update(['status' => '2']);

        if(!empty($results))
        {
            $message[] = 'Solicita&ccedil;&atilde;o reprovada com sucesso!';
            $code = 200;
        }
        else
        {
            $message[] = 'Erro ao tentar reprovar solicita&ccedil;&atilde;o';
            $code = 500;
        }

        # feedback
        $code = (!empty($code)) ? $code : 200;
        return response(['response' => $message, 'code' => $code]);
    }

    public function responsavel(Request $request)
    {
        $input = $request->all();

        $results = DB::table('empresa')
        ->where('id', $input['id_empresa'])
        ->update(['id_responsavel' => $input['id_usuario']]);

        if(!empty($results))
        {
            $message[] = 'Respons&aacute;vel vinculado com sucesso!';
            $code = 200;
        }
        else
        {
            $message[] = 'Erro ao tentar vincular respons&aacute;vel';
            $code = 500;
        }

        # feedback
        $code = (!empty($code)) ? $code : 200;
        return response(['response' => $message, 'code' => $code]);
    }

    public function addusuario(Request $request)
    {
        $input = $request->all();

        $aUsuario = DB::table('usuario')->where('usuario.cpf', '=', $input['identificador'])->orWhere('usuario.email', '=', $input['identificador'])->get();

        if($aUsuario->isNotEmpty())
        {
            if($aUsuario[0]->cpf == $_SESSION['cpf'] || $aUsuario[0]->email == $_SESSION['email'])
            {
                $message[] = 'Operacao Invalida: Voce nao pode se auto vincular a uma empresa';
                $code = 500;
            }
            else
            {
                $id_solicitacao =  DB::table('solicitacao')->insertGetId([
                    'id_usuario' => $aUsuario[0]->id,
                    'id_empresa' => $request->id_empresa,
                    'status' => 1,
                    'data_solicitacao' => date("Y-m-d H:i:s")
                ]);

                if(!empty($id_solicitacao))
                {
                    $message[] = 'Usu&aacute;rio vinculado com sucesso!';
                    $code      = 200;
                }
                else
                {
                    $message[] = 'Erro ao efetuar v&iacute;nculo';
                    $code = 500;
                }
            }
        }
        else
        {
            $message[] = 'CPF ou Email n&atilde;o encontrado';
            $code = 500;
        }

        # feedback
        $code = (!empty($code)) ? $code : 200;
        return response(['response' => $message, 'code' => $code]);
    }

    public function update(Request $request)
    {
        $input   = $request->all();

        $results = DB::table('empresa')
        ->where('id', $input['id'])
        ->update(['nome_fantasia' => $input['fantasia'],
            'razao_social'        => $input['social'],
            'email'               => $input['email'],
            'telefone'            => $input['tel'],
            'whatsapp'            => $input['whats'],
            'cep'                 => $input['cep'],
            'endereco'            => $input['endereco'],
            'numero'              => $input['numero'],
            'complemento'         => $input['complemento'],
            'bairro'              => $input['bairro'],
            'cidade'              => $input['cidade'],
            'estado'              => $input['estado'],
            'segmento'            => $input['segmento'],
            'usuario_alteracao'   => $_SESSION['id'],
            'data_alteracao'      => date("Y-m-d H:i:s")
        ]);

        if(!empty($results))
        {
            $message[] = 'Empresa alterada com sucesso!';
            $code = 200;
            $redirect = '/empresa/'.$input['id'].'/my-drive';
        }
        else
        {
            $message[] = 'Erro ao tentar alterar empresa';
            $code = 500;
            $redirect = '';
        }

        # feedback
        $code = (!empty($code)) ? $code : 200;
        return response(['response' => $message, 'code' => $code, 'redirect' => $redirect]);
    }
}
