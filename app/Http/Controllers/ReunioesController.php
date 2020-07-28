<?php

namespace App\Http\Controllers;

use App\Reunioes;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\DB;
use PHPMailer\PHPMailer;

require(dirname(__FILE__).'/../../../vendor/phpmailer/phpmailer/src/PHPMailer.php');
require(dirname(__FILE__).'/../../../vendor/phpmailer/phpmailer/src/SMTP.php');
require(dirname(__FILE__).'/../../../vendor/phpmailer/phpmailer/src/POP3.php');
require(dirname(__FILE__).'/../../../vendor/phpmailer/phpmailer/src/Exception.php');

class ReunioesController extends Controller
{
    public function __construct()
    {
        session_start();
    }
    public function index($id)
    {
        $aReunioes = DB::table('reuniao')->where('id_projeto','=',$id)->orderBy('reuniao.id', 'DESC')->get();

        return view('projetos.reunioes.agenda')->with('reunioes', $aReunioes);
    }

    public function detalhes($idProjeto, $idReuniao)
    {
        $aReuniao = DB::table('reuniao')->where('id','=',$idReuniao)->get();
        $aParticipantes = DB::select("SELECT usuario.*, participantes.status as status_panticipante FROM participantes inner join usuario on usuario.id = participantes.id_usuario WHERE participantes.id_reuniao = '" . $idReuniao . "'");

        $aDocumentos = DB::select("SELECT documentos.*, usuario.nome, DATE_FORMAT(documentos.data_alteracao, '%d/%m/%Y') as datinha FROM documentos left join usuario on usuario.id = documentos.usuario_alteracao where documentos.id_reuniao = " . $idReuniao . " and documentos.status != 3");

        $data=[
            'reuniao'  => $aReuniao[0],
            'participantes' => $aParticipantes,
            'documentos' => $aDocumentos
        ];

        return view('projetos.reunioes.detalhes')->with('detalhes', $data);
    }
    public function novo($id)
    {
        $aCategorias = DB::table('categoria')->where('categoria.id_vinculos','LIKE','%'.'4'.'%')->orderBy('categoria.id', 'DESC')->get();

        $aUsuarios = DB::select("SELECT usuario.*, solicitacao.id_projeto as Projeto FROM usuario inner join solicitacao on solicitacao.id_usuario = usuario.id WHERE solicitacao.id_projeto = '" . $id . "'");

        $data=[
            'categorias'  => $aCategorias,
            'usuarios'    =>$aUsuarios,
        ];

        return view('projetos.reunioes.novo')->with('detalhes', $data);
    }

    public function create(Request $request)
    {
        $input   = $request->all();
        $mail    = new PHPMailer\PHPMailer();

        parse_str($_POST['formulario'], $searcharray);

        $reuniao    = new Reunioes;
        $i          = 1;

        $reuniao->titulo            = $searcharray['titulo'];
        $reuniao->id_categoria      = $searcharray['categoria'];
        $reuniao->id_projeto        = $searcharray['idprojeto'];
        $reuniao->data              = $searcharray['data'];
        $reuniao->hora_inicio       = $searcharray['horainicio'];
        $reuniao->hora_fim          = $searcharray['horafim'];
        $reuniao->localizacao       = $searcharray['local'];
        $reuniao->descricao         = $searcharray['descricao'];
        $reuniao->texto_adicional   = $searcharray['textoadicional'];
        $reuniao->data_inclusao     = date('Y-m-d H:i:s');
        $reuniao->usuario_inclusao  = $_SESSION['id'];
        $reuniao->usuario_alteracao = '0';

        try
        {
            $reuniao->save();

            if($reuniao->wasRecentlyCreated == 1)
            {
                foreach($input['usuarios'] as $k=>$v)
                {
                    // Enviar Convite para Usuarios
                    $id_convite =  DB::table('participantes')->insertGetId([
                        'id_reuniao' => $reuniao->id,
                        'id_usuario' => $v,
                        'chk' => 'S',
                        'status' => 0
                    ]);

                    $usuario = DB::table('usuario')->where('id','=',$v)->get();

                    //Server settings
                    $mail->isSMTP();
                    $mail->Host = 'mail.buriti.arq.br';
                    $mail->Port = 587;
                    $mail->SMTPSecure = false;
                    $mail->SMTPAutoTLS = false;
                    $mail->SMTPAuth = true;
                    $mail->Username = "noreply@buriti.arq.br";
                    $mail->Password = "GaYB0ioL5!#@";

                    //Recipients
                    $mail->setFrom('noreply@buriti.arq.br', 'Buriti Arquitetura');
                    $mail->addAddress($usuario[0]->email, utf8_decode($usuario[0]->nome));

                    // Content
                    $mail->isHTML(true);
                    $mail->Subject = 'Convite - Buriti Arquitetura';
                    $mail->Body    = '<html>
                                        <head>
                                        	<meta charset="utf-8"/>
                                        	<meta http-equiv="X-UA-Compatible" content="IE=edge">
                                        	<title>Convite Sistema Buriti Arquitetura</title>
                                        </head>
                                        <body>
                                            <style>
                                            	* {
                                            		font-size: 14px;
                                            		line-height: 1.8em;
                                            		font-family: arial;
                                            	}
                                            </style>
                                        	<table style="margin:0 auto; max-width:660px;">
                                        		<thead>
                                        			<tr>
                                        				<th><img src="https://app.buriti.arq.br/assets/images/topoemail.png" style="width:100%" />  </th>
                                        			</tr>
                                        		</thead>
                                        		<tbody>
                                        			<tr>
                                        				<td><h3 style="margin:0px;text-align:center;display:block;color:#444444;font-size:22px;font-weight:bold;line-height:33px;padding-bottom: 20px; padding-top: 20px;">Ol&aacute;,'. utf8_decode($usuario[0]->nome).'</h3>
                                                        <h3 style="margin:0px;text-align:center;display:block;color:#444444;font-size:22px;font-weight:bold;line-height:33px;padding-bottom: 20px; padding-top: 20px;">Voce foi convidado para uma reuni&atilde;o</h3>
                                                            <p style="text-align:center;margin:10px 0;padding:0;color:#757575;font-family:Helvetica;font-size:16px;line-height:150%">Data: '.$searcharray['data'].'</p>
                                                            <p style="text-align:center;margin:10px 0;padding:0;color:#757575;font-family:Helvetica;font-size:16px;line-height:150%">Hora Inicio: '.$searcharray['horainicio'].'</p>
                                                            <p style="text-align:center;margin:10px 0;padding:0;color:#757575;font-family:Helvetica;font-size:16px;line-height:150%">Hora Final: '.$searcharray['horafim'].'</p>
                                                            <p style="text-align:center;margin:10px 0;padding:0;color:#757575;font-family:Helvetica;font-size:16px;line-height:150%">Local: '.$searcharray['local'].'</p>
                                                            <p style="text-align:center;margin:10px 0;padding:0;color:#757575;font-family:Helvetica;font-size:16px;line-height:150%">Descri&ccedil;&atilde;o: '.$searcharray['descricao'].'</p>
                                                            <p style="text-align:center;margin:10px 0;padding:0;color:#757575;font-family:Helvetica;font-size:16px;line-height:150%">Texto Adicional: '.$searcharray['textoadicional'].'</p><br>
                                                            <p style="text-align:center;margin:10px 0;padding:0;color:#757575;font-family:Helvetica;font-size:16px;line-height:150%">Acesse o Sistema para confirmar sua presen&ccedil;a</p>
                                        				</td>
                                        			</tr>
                                        			<tr>
                                        				<td>
                                        				</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="color:#333333;">
                                                            <hr style="border:0; border-top: 2px solid #505050; margin:20px;font-family:Helvetica;">
                                                            <p style="text-align:center; font-size:16px;">Avenida nove de julho, 4939 - cj 141 - bloco A - Jardim paulista
                                                            São Paulo - SP</p>
                                                            <p style="text-align:center; font-size:16px;"><a href="https://buriti.arq.br" target="_blank" >buriti.arq.br</a></p>
                                                            <p style="text-align:center; font-size:16px; padding-bottom:20px">Copyright © 2020 Buriti Arquitetura, All rights reserved.</p>
                                                        </td>
                                                    </tr>
                                        		</tbody>
                                        	</table>
                                           </body>
                                        </html>';

                    $mail->send();

                    // Limpa os destinat�rios e os anexos
                    $mail->ClearAllRecipients();
                    $mail->ClearAttachments();


                }

                $message[] = 'Reunião Agendada com sucesso!';
                $code      = 200;
            }
        }
        catch (Exception $e)
        {
            //$message[] = $e->getMessage();
            $message[] = '';
            $code      = 500;
        }

        # feedback
        $code = (!empty($code)) ? $code : 200;
        return response(['response' => $message, 'code' => $code]);
    }

    public function confirm($id)
    {
        $aParticipante = DB::table('participantes')->where('participantes.id_reuniao','=', $id)->where('participantes.id_usuario','=', $_SESSION['id'])->get();

        if(!empty($aParticipante))
        {
            $results = DB::table('participantes')
            ->where('id', $aParticipante[0]->id)
            ->update(['status' => 1]);

            $message[] = 'Reunião Confirmada com sucesso!';
            $code      = 200;
        }
        else
        {
            $message[] = 'Erro ao Confirmar Reunião!';
            $code      = 200;
        }

        # feedback
        $code = (!empty($code)) ? $code : 200;
        return response(['response' => $message, 'code' => $code]);
    }

    public function decline($id)
    {
        $aParticipante = DB::table('participantes')->where('participantes.id_reuniao','=', $id)->where('participantes.id_usuario','=', $_SESSION['id'])->get();

        if(!empty($aParticipante))
        {
            $results = DB::table('participantes')
            ->where('id', $aParticipante[0]->id)
            ->update(['status' => 2]);

            $message[] = 'Reunião Rejeitada com sucesso!';
            $code      = 200;
        }
        else
        {
            $message[] = 'Erro ao Rejeitar Reunião!';
            $code      = 200;
        }

        # feedback
        $code = (!empty($code)) ? $code : 200;
        return response(['response' => $message, 'code' => $code]);
    }

    public function edit($idProjeto, $idReuniao)
    {
        $aReuniao = DB::table('reuniao')->where('reuniao.id_projeto','=',$idProjeto)->where('reuniao.id','=',$idReuniao)->get();

        $aCategorias = DB::table('categoria')->where('categoria.id_vinculos','LIKE','%'.'4'.'%')->orderBy('categoria.id', 'DESC')->get();

      //  $aUsuarios = DB::select("SELECT usuario.*, participantes.id_reuniao as Reuniao, participantes.status as StatusParticipante FROM usuario inner join participantes on participantes.id_usuario = usuario.id WHERE participantes.id_reuniao = '" . $idReuniao . "'");

        $aUsuarios = DB::select("SELECT usuario.*,
                                        solicitacao.id_projeto as Projeto,
                                        participantes.chk as StatusParticipante
                                 FROM usuario
                                        inner join solicitacao on solicitacao.id_usuario = usuario.id
                                        left join participantes on participantes.id_usuario = usuario.id WHERE solicitacao.id_projeto = '" . $idProjeto . "' GROUP BY usuario.id");

        $data=[
            'reuniao'  => $aReuniao[0],
            'categorias' => $aCategorias,
            'usuarios' => $aUsuarios
        ];

        return view('projetos.reunioes.editar')->with('detalhes', $data);
    }

    public function update(Request $request, $id)
    {
        $input   = $request->all();

        $mail    = new PHPMailer\PHPMailer();

        parse_str($_POST['formulario'], $searcharray);

        $i = 1;

        $results = DB::table('reuniao')
        ->where('id', $searcharray['idreuniao'])
        ->update([
            'titulo'            => $searcharray['titulo'],
            'id_categoria'      => $searcharray['categoria'],
            'data'              => $searcharray['data'],
            'hora_inicio'       => $searcharray['horainicio'],
            'hora_fim'          => $searcharray['horafim'],
            'localizacao'       => $searcharray['local'],
            'descricao'         => $searcharray['descricao'],
            'texto_adicional'   => $searcharray['textoadicional'],
            'usuario_alteracao' => $_SESSION['id'],
            'data_alteracao'    => date("Y-m-d H:i:s")
        ]);

        if(!empty($results))
        {
            $deletar = DB::table('participantes')
            ->where('id_reuniao', $searcharray['idreuniao'])
            ->delete();

            foreach($input['usuarios'] as $k=>$v)
            {
                // Enviar Convite para Usuarios
                $id_convite =  DB::table('participantes')->insertGetId([
                    'id_reuniao' => $searcharray['idreuniao'],
                    'id_usuario' => $v,
                    'chk' => 'S',
                    'status' => 0
                ]);

                $usuario = DB::table('usuario')->where('id','=',$v)->get();

                //Server settings
                $mail->isSMTP();
                $mail->Host = 'mail.buriti.arq.br';
                $mail->Port = 587;
                $mail->SMTPSecure = false;
                $mail->SMTPAutoTLS = false;
                $mail->SMTPAuth = true;
                $mail->Username = "noreply@buriti.arq.br";
                $mail->Password = "GaYB0ioL5!#@";

                //Recipients
                $mail->setFrom('noreply@buriti.arq.br', 'Buriti Arquitetura');
                $mail->addAddress($usuario[0]->email, utf8_decode($usuario[0]->nome));

                // Content
                $mail->isHTML(true);
                $mail->Subject = 'Convite - Buriti Arquitetura';
                $mail->Body    = '<html>
                                        <head>
                                        	<meta charset="utf-8"/>
                                        	<meta http-equiv="X-UA-Compatible" content="IE=edge">
                                        	<title>Convite Sistema Buriti Arquitetura</title>
                                        </head>
                                        <body>
                                            <style>
                                            	* {
                                            		font-size: 14px;
                                            		line-height: 1.8em;
                                            		font-family: arial;
                                            	}
                                            </style>
                                        	<table style="margin:0 auto; max-width:660px;">
                                        		<thead>
                                        			<tr>
                                        				<th><img src="https://app.buriti.arq.br/assets/images/topoemail.png" style="width:100%" />  </th>
                                        			</tr>
                                        		</thead>
                                        		<tbody>
                                        			<tr>
                                        				<td><h3 style="margin:0px;text-align:center;display:block;color:#444444;font-size:22px;font-weight:bold;line-height:33px;padding-bottom: 20px; padding-top: 20px;">Ol&aacute;,'. utf8_decode($usuario[0]->nome).'</h3>
                                            			<h3 style="margin:0px;text-align:center;display:block;color:#444444;font-size:22px;font-weight:bold;line-height:33px;padding-bottom: 20px; padding-top: 20px;">	Voce foi convidado para uma reuni&atilde;o</h3>
                                                            <p style="text-align:center;margin:10px 0;padding:0;color:#757575;font-family:Helvetica;font-size:16px;line-height:150%">Data: '.$searcharray['data'].'</p>
                                                            <p style="text-align:center;margin:10px 0;padding:0;color:#757575;font-family:Helvetica;font-size:16px;line-height:150%">Hora Inicio: '.$searcharray['horainicio'].'</p>
                                                            <p style="text-align:center;margin:10px 0;padding:0;color:#757575;font-family:Helvetica;font-size:16px;line-height:150%">Hora Final: '.$searcharray['horafim'].'</p>
                                                            <p style="text-align:center;margin:10px 0;padding:0;color:#757575;font-family:Helvetica;font-size:16px;line-height:150%">Local: '.$searcharray['local'].'</p>
                                                            <p style="text-align:center;margin:10px 0;padding:0;color:#757575;font-family:Helvetica;font-size:16px;line-height:150%">Descri&ccedil;&atilde;o: '.$searcharray['descricao'].'</p>
                                                            <p style="text-align:center;margin:10px 0;padding:0;color:#757575;font-family:Helvetica;font-size:16px;line-height:150%">Texto Adicional: '.$searcharray['textoadicional'].'</p><br>
                                                            <p style="text-align:center;margin:10px 0;padding:0;color:#757575;font-family:Helvetica;font-size:16px;line-height:150%">Acesse o Sistema para confirmar sua presen&ccedil;a</p>
                                        				</td>
                                        			</tr>
                                        			<tr>
                                        				<td>
                                        				</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="color:#333333;">
                                                            <hr style="border:0; border-top: 2px solid #505050; margin:20px;font-family:Helvetica;">
                                                            <p style="text-align:center; font-size:16px; ">Avenida nove de julho, 4939 - cj 141 - bloco A - Jardim paulista
                                                            São Paulo - SP</p>
                                                            <p style="text-align:center; font-size:16px; "><a href="https://buriti.arq.br" target="_blank" >buriti.arq.br</a></p>
                                                            <p style="text-align:center; font-size:16px; padding-bottom:20px">Copyright © 2020 Buriti Arquitetura, All rights reserved.</p>
                                                        </td>
                                                    </tr>
                                        		</tbody>
                                        	</table>
                                           </body>
                                        </html>';

                $mail->send();

                // Limpa os destinat�rios e os anexos
                $mail->ClearAllRecipients();
                $mail->ClearAttachments();


            }

            $message[] = 'Reunião Alterada com sucesso!';
            $code      = 200;
            $redirect = $redirect = 'http://'.$_SERVER['HTTP_HOST'].'/projeto/'.$_SESSION['idprojeto'].'/reunioes/detalhes/'.$searcharray['idreuniao'];
        }
        else
        {
            $message[] = 'Erro ao tentar alterar Reunião';
            $code = 500;
            $redirect = '';
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
        $destinationPath = base_path('public/reuniao');
        $urlreal         = '/reuniao/'.$newname.'.'.$extensao;
        $file->move($destinationPath,$newname.'.'.$extensao);

        if(!empty($file))
        {
            return response(['dir' => $urlreal, 'name' => $newname.'.'.$extensao]);
        }
    }

    public function gravardocumento(Request $request)
    {
        $input   = $request->all();

        // Grava Documento da Reuniao
        $gravou =  DB::table('documentos')->insertGetId([
            'descricao' => $input['descricao'],
            'documento' => $input['documento'],
            'link' => $input['link'],
            'status' => $input['status'],
            'id_projeto' => $input['idprojeto'],
            'id_reuniao' => $input['idreuniao'],
            'arquivo' => $input['url'],
            'arquivo' => $input['url'],
            'usuario_inclusao' =>$_SESSION['id'],
            'data_inclusao' =>date('Y-m-d H:i:s')
        ]);


        if(!empty($gravou))
        {
            $message[] = 'Documento gravado com sucesso!';
            $code = 200;
        }
        else
        {
            $message[] = 'Erro ao Gravar Documento!';
            $code = 500;
        }

        # feedback
        $code = (!empty($code)) ? $code : 200;
        return response(['response' => $message, 'code' => $code]);
    }

    public function listagem($id)
    {
        $aReunioes = DB::table('reuniao')->where('id_projeto', '=', $id)->get();
        $eventos     = array();

        /*
         *
          events: [{
            title: "Go to Library",
            start: new Date(year, month, date, 08, 30),
            end: new Date(year, month, date, 14, 10),
            color: "#ffc107"

            start: '2020-06-24T10:30:00', end: '2020-06-24T11:30:00',}
        }]
         *
         */

        foreach($aReunioes as $k=>$v)
        {
            $aData = (explode("/",$v->data));

            $aHoraI = (explode(":",$v->hora_inicio));
            $aHoraF = (explode(":",$v->hora_fim));

            $title  = $v->titulo;
            $start  = $aData[2]. '-' . $aData[1] . '-' . $aData[0] .'T'.$aHoraI[0]. ':' .$aHoraI[1].':00';
            $end    = $aData[2]. '-' . $aData[1] . '-' . $aData[0] .'T'.$aHoraF[0]. ':' .$aHoraF[1].':00';
            $color  = '#529ef0';

            $eventos[] = [

                'title' => $title,
                'start' => $start,
                'end' => $end,
                'color' => $color
            ];

        }

        $Ret = json_encode($eventos);

        echo($Ret);
    }

    public function aprovar($id)
    {
        $results = DB::table('documentos')
        ->where('id', $id)
        ->update([
            'status'            => 1,
            'usuario_alteracao' => $_SESSION['id'],
            'data_alteracao'    => date("Y-m-d H:i:s")
        ]);

        if(!empty($results))
        {
            $message[] = 'Documento Aprovado com Sucesso';
            $code      = 200;
        }
        else
        {
            $message[] = 'Erro ao tentar Aprovar Documento';
            $code      = 500;
        }

        # feedback
        $code = (!empty($code)) ? $code : 200;
        return response(['response' => $message, 'code' => $code]);
    }

    public function reprovar($id)
    {
        $results = DB::table('documentos')
        ->where('id', $id)
        ->update([
            'status'            => 2,
            'usuario_alteracao' => $_SESSION['id'],
            'data_alteracao'    => date("Y-m-d H:i:s")
        ]);

        if(!empty($results))
        {
            $message[] = 'Documento Reprovado com Sucesso';
            $code      = 200;
        }
        else
        {
            $message[] = 'Erro ao tentar Reprovar Documento';
            $code      = 500;
        }

        # feedback
        $code = (!empty($code)) ? $code : 200;
        return response(['response' => $message, 'code' => $code]);
    }

    public function excluir($id)
    {
        $results = DB::table('documentos')
        ->where('id', $id)
        ->update([
            'status'            => 3, // Excluido
            'usuario_alteracao' => $_SESSION['id'],
            'data_alteracao'    => date("Y-m-d H:i:s")
        ]);

        if(!empty($results))
        {
            $message[] = 'Documento Excluido com Sucesso';
            $code      = 200;
        }
        else
        {
            $message[] = 'Erro ao tentar Excluir Documento';
            $code      = 500;
        }

        # feedback
        $code = (!empty($code)) ? $code : 200;
        return response(['response' => $message, 'code' => $code]);
    }

    public function editardoc($id)
    {
        $aDocumento = DB::table('documentos')->where('documentos.id', '=', $id)->get();

        # feedback
        $code = (!empty($code)) ? $code : 200;
        return response()->json(array('response' => $aDocumento));
    }

    public function atualizar(Request $request)
    {
        $input   = $request->all();

        $results = DB::table('documentos')
        ->where('id', $input['idocumento'])
        ->update([
            'descricao'         => $input['descricaoedit'],
            'documento'         => $input['documentoedit'],
            'link'              => $input['linkedit'],
            'status'            => $input['statusedit'],
            'arquivo'           => $input['urledit'],
            'usuario_alteracao' => $_SESSION['id'],
            'data_alteracao'    => date("Y-m-d H:i:s")
        ]);

        if(!empty($results))
        {
            $message[] = 'Documento alterado com sucesso!';
            $code = 200;
        }
        else
        {
            $message[] = 'Erro ao tentar alterar Documento';
            $code = 500;
        }

        # feedback
        $code = (!empty($code)) ? $code : 200;
        return response(['response' => $message, 'code' => $code]);
    }
}
