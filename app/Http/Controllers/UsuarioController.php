<?php

namespace App\Http\Controllers;

use App\Usuario;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\DB;
use PHPMailer\PHPMailer;

require(dirname(__FILE__).'/../../../vendor/phpmailer/phpmailer/src/PHPMailer.php');
require(dirname(__FILE__).'/../../../vendor/phpmailer/phpmailer/src/SMTP.php');
require(dirname(__FILE__).'/../../../vendor/phpmailer/phpmailer/src/POP3.php');
require(dirname(__FILE__).'/../../../vendor/phpmailer/phpmailer/src/Exception.php');

class UsuarioController extends Controller
{
    public function login(Request $request)
    {
        session_start();
        $input  = $request->all();
        $id  = Usuario::where('email', '=', $input['email'])->where('senha', '=', $input['senha'])->where('status', '=', 1)->orWhere('cpf', '=', $input['email'])->where('senha', '=', $input['senha'])->where('status', '=', 1)->pluck('id');

        if($id->isNotEmpty())
        {
            $aUser = Usuario::find($id);

            $_SESSION['id']     = $aUser[0]->id;
            $_SESSION['nome']   = $aUser[0]->nome;
            $_SESSION['email']  = $aUser[0]->email;
            $_SESSION['cpf']    = $aUser[0]->cpf;
            $_SESSION['tipo']   = $aUser[0]->tipo_usuario;
            $_SESSION['status'] = $aUser[0]->status;

            if($_SESSION['status'] == 0)
            {
                $message[] = 'Usu&aacute;rio pendente de aprova&ccedil;&atilde;o';
                $code      = 500;
                $redirect  = 'nao direciona';
                return response(['response' => $message, 'code' => $code, 'redirect' => $redirect]);
            }

            $message[] = 'Usuario logado com sucesso!';
            $code      = 200;

            if($_SESSION['tipo'] == '0' || $_SESSION['tipo'] == '2')
            {
                $redirect  = '/dashboard-admin';
            }
            else
            {
                $redirect  = '/dashboard-cliente';
            }
        }
        else
        {
            $message[] = 'Usu&aacute;rio o Senha Incorreto';
            $code      = 500;
            $redirect  = 'nao direciona';
        }

        # feedback
        $code = (!empty($code)) ? $code : 200;
        return response(['response' => $message, 'code' => $code, 'redirect' => $redirect]);
    }

    public function logout()
    {
        session_start();
        session_destroy();
        header('Location: /');
        die();
    }

    public function index()
    {
        //
    }

    public function create(Request $request)
    {
        $input   = $request->all();
        $usuario = new Usuario;

        $usuario->nome              = $request->nome;
        $usuario->email             = $request->email;
        $usuario->cpf               = $request->cpf;
        $usuario->data_nascimento   = $request->nascimento;
        $usuario->telefone          = $request->telefone;
        $usuario->whatsapp          = $request->whatsapp;
        $usuario->cep               = $request->cep;
        $usuario->endereco          = $request->endereco;
        $usuario->numero            = $request->numero;
        $usuario->complemento       = $request->complemento;
        $usuario->bairro            = $request->bairro;
        $usuario->cidade            = $request->cidade;
        $usuario->estado            = $request->estado;
        $usuario->senha             = $request->senha;
        $usuario->tipo_usuario      = '1';
        $usuario->status            = '0'; // Entra como Pendente
        $usuario->data_inclusao     = date('Y-m-d H:i:s');
        $usuario->usuario_inclusao  = '0'; // Cadastrado Manualmente
        $usuario->usuario_alteracao = '0';

        $usuario->save();

        if($usuario->wasRecentlyCreated == 1)
        {
            $message[] = 'Ol&aacute;! Aguarde a aprova&ccedil;&atilde;o do seu cadastro para manusear nossos recursos. Em breve retornaremos.';
            $code      = 200;
            $redirect  = '/';
        }
        else
        {
            $message[] = 'Erro ao Cadastrar Usu&aacute;rio';
            $code      = 500;
            $redirect  = '';
        }

        # feedback
        $code = (!empty($code)) ? $code : 200;
        return response(['response' => $message, 'code' => $code, 'redirect' => $redirect]);
    }

    public function profile($id)
    {
        session_start();

        if($_SESSION['id'] != $id)
        {
            header("Location: /404");
            die();
        }
        else
        {
            $aDados = DB::table('usuario')->find($id);
            return view('usuario.minha-conta')->with('dados', $aDados);
        }
    }

    public function update(Request $request)
    {
        session_start();

        $input   = $request->all();

        $results = DB::table('usuario')
                ->where('id', $input['id'])
                ->update(['cpf'   => $input['cpf'],
                          'data_nascimento'   => $input['nascimento'],
                          'cep'               => $input['cep'],
                          'endereco'          => $input['endereco'],
                          'numero'            => $input['numero'],
                          'complemento'       => $input['complemento'],
                          'bairro'            => $input['bairro'],
                          'cidade'            => $input['cidade'],
                          'telefone'          => $input['telefone'],
                          'whatsapp'          => $input['whatsapp'],
                          'estado'            => $input['estado'],
                          'senha'             => $input['senha'],
                          'usuario_alteracao' => $_SESSION['id'],
                          'data_alteracao'    => date("Y-m-d H:i:s")
                ]);

                if(!empty($results))
                {
                    $message[] = 'Usu&aacute;rio alterado com sucesso!';
                    $code = 200;
                    $redirect = '/minha-conta/'.$input['id'];
                }
                else
                {
                    $message[] = 'Erro ao tentar alterar usu&aacute;rio';
                    $code = 500;
                    $redirect = '';
                }

                # feedback
                $code = (!empty($code)) ? $code : 200;
                return response(['response' => $message, 'code' => $code, 'redirect' => $redirect]);
    }

    public function esqueci(Request $request)
    {
        $aUsuario =  DB::select("SELECT * FROM usuario WHERE usuario.email = '" . $request->email . "'");
        $mail     = new PHPMailer\PHPMailer();

        if(!empty($aUsuario))
        {
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
            $mail->addAddress($request->email, utf8_decode($aUsuario[0]->nome));

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Esqueci minha senha';
            $mail->Body    = '<html>
            <head>
                <meta charset="utf-8"/>
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <title>Esqueci minha Senha</title>
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
                            <th><img src="https://app.buriti.arq.br/assets/images/topoemail.png" />  </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><h3 style="margin:0px;text-align:center;display:block;color:#444444;font-size:22px;font-weight:bold;line-height:33px;padding-bottom: 20px; padding-top: 20px;">Ol&aacute;,'. utf8_decode($aUsuario[0]->nome).'</h3>
                                <p style="margin-bottom: 30px; text-align: center; color:#757575;font-family:Helvetica;font-size:16px;line-height:150%">Foi solicitado o envio de sua senha para acessar o sistema.</p>

                            </td>
                        </tr>
                        <tr>
                            <td style="text-align:center">
                                <p style="margin-bottom: 30px; text-align: center; color:#757575;font-family:Helvetica;font-size:16px;line-height:150%"><strong>Email: </strong>'.$aUsuario[0]->email.'</p>
                                <p style="margin-bottom: 30px; text-align: center; color:#757575;font-family:Helvetica;font-size:16px;line-height:150%"><strong>Senha: </strong>'.$aUsuario[0]->senha.'</p>
                            </td>
                        </tr>
                        <tr>
                        <td>
                        </td>
                    </tr>
                    <tr>
                        <td style="background:#333333; color:#fff;">
                            <hr style="border:0; border-top: 2px solid #505050; margin:20px;font-family:Helvetica;">
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

            $message[] = 'Senha enviada com sucesso!';
            $code      = 200;
            $redirect  = '/';
    }
    else
    {
        $message[] = 'E-mail n&atilde;o localizado';
        $code      = 500;
        $redirect  = '';
    }

        # feedback
        $code = (!empty($code)) ? $code : 200;
        return response(['response' => $message, 'code' => $code]);
    }

    public function notificacoes()
    {
        session_start();

        $aRet          =  DB::select("SELECT * FROM notificacao WHERE notificacao.status = 0 and notificacao.id_usuario_recebe = ".$_SESSION['id']);
        $html          = '';

        # Montagem Front Notificacoes
        for($i=0; $i < count($aRet); $i++)
        {
            $html .= '<div id="'.$aRet[$i]->id.'" onclick="AtualizaNotificacao('.$aRet[$i]->id.')" class="dropdown-item d-flex">';
            $html .= '<div class="notification-icon">';
            $html .= '<i class="i-Speach-Bubble-6 text-primary mr-1"></i>';
            $html .= '</div>';
            $html .= '<div class="notification-details flex-grow-1">';
            $html .= '<p class="m-0 d-flex align-items-center">';
            $html .= '<span>Nova Mensagem</span>';
            $html .= '<span class="badge badge-pill badge-primary ml-1 mr-1">new</span>';
            $html .= '<span class="flex-grow-1"></span>';
            $html .= '<span class="text-small text-muted ml-auto">'.date("d/m/Y", strtotime($aRet[$i]->data_notificacao)).'</span>';
            $html .= '</p>';
            $html .= '<p class="text-small text-muted m-0">'.$aRet[$i]->mensagem.'</p>';
            $html .= '</div>';
            $html .= '</div>';
        }

        $aRet['total'] = count($aRet);
        $aRet['html']  = $html;

        # feedback
        $code = (!empty($code)) ? $code : 200;
        return response(['response' => '', 'code' => $code, 'dados' => $aRet]);
    }

    public function atualizanotificacoes(Request $request)
    {
        session_start();

        $input   = $request->all();

        $results = DB::table('notificacao')
        ->where('id', $input['id'])
        ->update(['status'   => 1
        ]);

        $aRet          =  DB::select("SELECT * FROM notificacao WHERE notificacao.status = 0 and notificacao.id_usuario_recebe = ".$_SESSION['id']);
        $html          = '';

        # Montagem Front Notificacoes
        for($i=0; $i < count($aRet); $i++)
        {
            $html .= '<div id="'.$aRet[$i]->id.'" onclick="AtualizaNotificacao('.$aRet[$i]->id.')" class="dropdown-item d-flex">';
            $html .= '<div class="notification-icon">';
            $html .= '<i class="i-Speach-Bubble-6 text-primary mr-1"></i>';
            $html .= '</div>';
            $html .= '<div class="notification-details flex-grow-1">';
            $html .= '<p class="m-0 d-flex align-items-center">';
            $html .= '<span>Nova Mensagem</span>';
            $html .= '<span class="badge badge-pill badge-primary ml-1 mr-1">new</span>';
            $html .= '<span class="flex-grow-1"></span>';
            $html .= '<span class="text-small text-muted ml-auto">'.date("d/m/Y", strtotime($aRet[$i]->data_notificacao)).'</span>';
            $html .= '</p>';
            $html .= '<p class="text-small text-muted m-0">'.$aRet[$i]->mensagem.'</p>';
            $html .= '</div>';
            $html .= '</div>';
        }

        $aRet['total'] = count($aRet);
        $aRet['html']  = $html;

        # feedback
        $code = (!empty($code)) ? $code : 200;
        return response(['response' => '', 'code' => $code, 'dados' => $aRet]);
    }
    public function listausuario()
    {
        session_start();
        $aUsuarios = array();
        $aUsuarios = DB::select('SELECT * FROM usuario WHERE usuario.status = 0');
        return view('aprovacoes.usuarios')->with('usuarios', $aUsuarios);
    }

    public function aprovar(Request $request)
    {
        $input = $request->all();

        $results = DB::table('usuario')
        ->where('id', $input['id'])
        ->update(['status' => '1']);

        $aUsuario =  DB::select("SELECT * FROM usuario WHERE usuario.id = '" . $input['id'] . "'");
        $mail     = new PHPMailer\PHPMailer();

        if(!empty($aUsuario))
        {
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
            $mail->addAddress($aUsuario[0]->email, utf8_decode($aUsuario[0]->nome));

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Usuario Aprovado - Sistema Santista Controle Ambiental';
            $mail->Body    = '<html>
                                        <head>
                                        	<meta charset="utf-8"/>
                                        	<meta http-equiv="X-UA-Compatible" content="IE=edge">
                                        	<title>Aprova&ccedil;&atilde;o de Usu&aacute;rio</title>
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
                                        				<th><img src="http://cliente.santistacontroleambiental.com.br/assets/images/santista-controle-ambiental.png" />  </th>
                                        			</tr>
                                        		</thead>
                                        		<tbody>
                                        			<tr>
                                        				<td><p style="padding-bottom:20px; text-align:center;">Ol&aacute;,'. utf8_decode($aUsuario[0]->nome).'</p>
                                            				Seu usu&aacute;rio foi <strong>aprovado</strong> para acessar o sistema, abaixo suas credenciais:.<br>
                                                            <p><strong>Email: </strong>'.$aUsuario[0]->email.'</p>
                                                            <p><strong>Senha: </strong>'.$aUsuario[0]->senha.'</p>
                                        				</td>
                                        			</tr>
                                        			<tr>
                                        				<td>
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

            $message[] = 'Usu&aacute;rio aprovado com sucesso!';
            $code = 200;
            $redirect = '/aprovacoes/usuarios';
        }

        # feedback
        $code = (!empty($code)) ? $code : 200;
        return response(['response' => $message, 'code' => $code, 'redirect' => $redirect]);
    }

    public function reprovar(Request $request)
    {
        $input = $request->all();

        $results = DB::table('usuario')
        ->where('id', $input['id'])
        ->update(['status' => '2']);

        $aUsuario =  DB::select("SELECT * FROM usuario WHERE usuario.id = '" . $input['id'] . "'");
        $mail     = new PHPMailer\PHPMailer();

        if(!empty($aUsuario))
        {
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
            $mail->addAddress($aUsuario[0]->email, utf8_decode($aUsuario[0]->nome));

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Aprova��o de Usu�rio';
            $mail->Body    = '<html>
                                        <head>
                                        	<meta charset="utf-8"/>
                                        	<meta http-equiv="X-UA-Compatible" content="IE=edge">
                                        	<title>Aprova&ccedil;&atilde;o de Usu&aacute;rio</title>
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
                                        				<th><img src="http://cliente.santistacontroleambiental.com.br/assets/images/santista-controle-ambiental.png" />  </th>
                                        			</tr>
                                        		</thead>
                                        		<tbody>
                                        			<tr>
                                        				<td><p style="padding-bottom:20px; text-align:center;">Ol&aacute;,'. utf8_decode($aUsuario[0]->nome).'</p>
                                            				Seu usu&aacute;rio foi <strong>reprovado</strong> para acessar o sistema.<br>
                                        				</td>
                                        			</tr>
                                        			<tr>
                                        				<td>
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

            $message[] = 'Usu&aacute;rio reprovado com sucesso!';
            $code = 200;
            $redirect = '/aprovacoes/usuarios';
        }

        # feedback
        $code = (!empty($code)) ? $code : 200;
        return response(['response' => $message, 'code' => $code, 'redirect' => $redirect]);
    }

    public function usuarioprojeto($id)
    {
        session_start();

        $aUsers = DB::select("SELECT usuario.*, solicitacao.id_projeto as Projeto FROM usuario inner join solicitacao on solicitacao.id_usuario = usuario.id WHERE solicitacao.id_projeto = '" . $id . "'");

        return view('projetos.usuarios.listagem')->with('usuarios', $aUsers);
    }

    public function convite(Request $request)
    {
        session_start();
        $input   = $request->all();
        $mail    = new PHPMailer\PHPMailer();

        //Verifica se usuario existe
        $aUser = DB::table('usuario')->where('email', '=', $input['email'])->get();

        if($aUser->isEmpty())
        {
            //Gera uma string random e converte para hedadecimal
            $pass = openssl_random_pseudo_bytes(8);
            $pass = bin2hex($pass);

            $usuario = new Usuario;

            $usuario->nome              = $input['nome'];
            $usuario->email             = $input['email'];
            $usuario->cpf               = '';
            $usuario->data_nascimento   = '';
            $usuario->telefone          = '';
            $usuario->whatsapp          = '';
            $usuario->cep               = '';
            $usuario->endereco          = '';
            $usuario->numero            = '';
            $usuario->complemento       = '';
            $usuario->bairro            = '';
            $usuario->cidade            = '';
            $usuario->estado            = '';
            $usuario->senha             = $pass;
            $usuario->tipo_usuario      = '1';
            $usuario->status            = '1'; // Entra como Ativo
            $usuario->data_inclusao     = date('Y-m-d H:i:s');
            $usuario->usuario_inclusao  = $_SESSION['id'];
            $usuario->usuario_alteracao = '0';

            $usuario->save();

            if($usuario->wasRecentlyCreated == 1)
            {
                // Vincular usuario a um Projeto
                $id_vinculo =  DB::table('solicitacao')->insertGetId([
                    'id_usuario' => $usuario->id,
                    'id_projeto' => $input['idprojeto'],
                    'status' => 0,
                    'data_convite' => date("Y-m-d H:i:s")
                ]);

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
                $mail->addAddress($usuario->email, utf8_decode($usuario->nome));

                // Content
                $mail->isHTML(true);
                $mail->Subject = 'Convite  - Buriti Arquitetura';
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
                                <td><img src="https://app.buriti.arq.br/assets/images/topoemail.png" style="width:100%;" />  </td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><h3 style="margin:0px;text-align:center;display:block;color:#444444;font-size:22px;font-weight:bold;line-height:33px;padding-bottom: 20px; padding-top: 20px;">Ol&aacute;, '. utf8_decode($usuario->nome).'</h3>
                                    <p style="margin-bottom: 30px; text-align: center; color:#757575;font-family:Helvetica;font-size:16px;line-height:150%">Vamos come&ccedil;ar o seu projeto...</p>
                                </td>
                            </tr>
                            <tr>
                                <td><img src="https://app.buriti.arq.br/assets/images/telalogin.png" style="width:100%;" /></td>
                            </tr>
                            <tr>
                                <td><h3 style="text-align:center;display:block;margin:0;padding:0; padding-top:20px; color:#444444;font-family:Helvetica;font-size:22px;font-style:normal;font-weight:bold;line-height:150%;letter-spacing:normal">Para isso voc&ecirc; precisa acessar o nosso sistema!</h3>
                                <p style="text-align:center;margin:10px 0;padding:0;color:#757575;font-family:Helvetica;font-size:16px;line-height:150%">Nele voc&ecirc; ir&aacute; acompanhar os <strong>prazos</strong>,<strong> or&ccedil;amentos </strong>e os <strong>arquivos do projeto.</strong><br> Tamb&eacute;m ter&eacute; acesso as pautas e atas das nossas reuni&otilde;es e far&aacute; as aprova&ccedil;&otilde;es de todos os itens! Assim voc&ecirc; conseguir&aacute; acompanhar todo o passo a passo: tanto de<strong> design </strong>como <strong>financeiro </strong>da sua obra.</p></td>

                            </tr>
                            <tr>
                                <td style="color:#757575;font-family:Helvetica;font-size:16px;line-height:150%;text-align:left;padding:0 18px 9px 18px">
                                <h3 style="text-align:left;display:block;margin:0;padding:0;color:#444444;font-family:Helvetica;font-size:22px;font-style:normal;font-weight:bold;line-height:150%;letter-spacing:normal">&nbsp;</h3>
                                <h3 style="text-align:center;display:block;margin:0;padding:0;color:#444444;font-family:Helvetica;font-size:22px;font-style:normal;font-weight:bold;line-height:150%;letter-spacing:normal">Para login utilize:</h3>
                                <p style="text-align:center;margin:10px 0;padding:0;color:#757575;font-family:Helvetica;font-size:16px;line-height:150%"><strong>Email:&nbsp;</strong><a href="mailto:'. utf8_decode($usuario->email).'" target="_blank">'. utf8_decode($usuario->email).'</a></p>
                                <p style="text-align:center;margin:10px 0;padding:0;color:#757575;font-family:Helvetica;font-size:16px;line-height:150%"><strong>Senha:&nbsp;</strong>'. $pass.'</p>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-family:Helvetica;font-size:18px;padding:18px" align="center" valign="middle">
                                    <a href="https://app.buriti.arq.br/" title="Acessar" style="font-weight:bold;letter-spacing:-0.5px;line-height:100%;text-align:center;     border-collapse: separate!important;    border-radius: 3px;   background-color: #009fc7;text-decoration:none;color:#ffffff;  display: inline-block;    padding: 16px; font-size:18px;" target="_blank">Acessar</a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                </td>
                            </tr>
                            <tr>
                                <td style=" color:#333333;">
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
                </html> ';

                $mail->send();

                // Limpa os destinat�rios e os anexos
                $mail->ClearAllRecipients();
                $mail->ClearAttachments();

                $message[] = 'Usu&aacute;rio Convidado com sucesso!';
                $code = 200;
            }
            else
            {
                $message[] = 'Erro ao Convidar Usu&aacute;rio';
                $code      = 500;
                $redirect  = '';
            }
        }
        elseif($aUser->isNotEmpty())
        {
            //Verifica se o usuario ja esta vinculado a esse projeto
            $aProjetos = DB::table('solicitacao')->where('id_usuario', '=', $aUser[0]->id)->where('id_projeto', '=', $input['idprojeto'])->get();

            if($aProjetos->isEmpty())
            {
                $id_vinculo =  DB::table('solicitacao')->insertGetId([
                    'id_usuario' => $aUser[0]->id,
                    'id_projeto' => $input['idprojeto'],
                    'status' => 0,
                    'data_convite' => date("Y-m-d H:i:s")
                ]);
            }
            else
            {
                $message[] = 'Usu&aacute;rio ja vinculado a esse Projeto!';
                $code = 500;

                # feedback exception
                $code = (!empty($code)) ? $code : 200;
                return response(['response' => $message, 'code' => $code]);
            }

            //Server settings
            $mail->isSMTP();
            $mail->Host = 'mail.buriti.arq.br';
            $mail->Host = 'mail.buriti.arq.br';
            $mail->Port = 587;
            $mail->SMTPSecure = false;
            $mail->SMTPAutoTLS = false;
            $mail->SMTPAuth = true;
            $mail->Username = "noreply@buriti.arq.br";
            $mail->Password = "GaYB0ioL5!#@";

            //Recipients
            $mail->setFrom('noreply@buriti.arq.br', 'Buriti Arquitetura');
            $mail->addAddress($aUser[0]->email, utf8_decode($aUser[0]->nome));

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Convite  - Buriti Arquitetura';
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
                            <td><img src="https://app.buriti.arq.br/assets/images/topoemail.png" style="width:100%" />  </td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><h3 style="margin:0px;text-align:center;display:block;color:#444444;font-size:22px;font-weight:bold;line-height:33px;padding-bottom: 20px; padding-top: 20px;">Ol&aacute;,'. utf8_decode($aUser[0]->nome).'</h3>
                                <p style="margin-bottom: 30px; text-align: center; color:#757575;font-family:Helvetica;font-size:16px;line-height:150%">Vamos come&ccedil;ar o seu projeto...</p>
                            </td>
                        </tr>
                        <tr>
                            <td><img src="https://app.buriti.arq.br/assets/images/telalogin.png"  style="width:100%" /></td>
                        </tr>
                        <tr>
                            <td><h3 style="text-align:center;display:block;margin:0;padding:0; padding-top:30px; color:#444444;font-family:Helvetica;font-size:22px;font-style:normal;font-weight:bold;line-height:150%;letter-spacing:normal">Para isso voc&ecirc; precisa acessar o nosso sistema!</h3>
                            <p style="text-align:center;margin:10px 0;padding:0;color:#757575;font-family:Helvetica;font-size:16px;line-height:150%">Nele voc&ecirc; ir&aacute; acompanhar os <strong>prazos</strong>,<strong> or&ccedil;amentos </strong>e os <strong>arquivos do projeto.</strong><br> Tamb&eacute;m ter&aacute; acesso as pautas e atas das nossas reuni&otilde;es e far&aacute; as aprova&ccedil;&otilde;es de todos os itens! Assim voc&ecirc; conseguir&aacute; acompanhar todo o passo a passo: tanto de<strong> design </strong>como <strong>financeiro </strong>da sua obra.</p></td>

                        </tr>
                        <tr>
                            <td style="color:#757575;font-family:Helvetica;font-size:16px;line-height:150%;text-align:left;padding:0 18px 9px 18px">
                            <h3 style="text-align:left;display:block;margin:0;padding:0;color:#444444;font-family:Helvetica;font-size:22px;font-style:normal;font-weight:bold;line-height:150%;letter-spacing:normal">&nbsp;</h3>
                            <h3 style="text-align:center;display:block;margin:0;padding:0;color:#444444;font-family:Helvetica;font-size:22px;font-style:normal;font-weight:bold;line-height:150%;letter-spacing:normal">Para login utilize:</h3>
                            <p style="text-align:center;margin:10px 0;padding:0;color:#757575;font-family:Helvetica;font-size:16px;line-height:150%"><strong>Email:&nbsp;</strong><a href="mailto:'. utf8_decode($aUser[0]->email).'" target="_blank">'. utf8_decode($aUser[0]->email).'</a></p>
                            <p style="text-align:center;margin:10px 0;padding:0;color:#757575;font-family:Helvetica;font-size:16px;line-height:150%"><strong>Senha:&nbsp;</strong>'. $aUser[0]->senha.'</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-family:Helvetica;font-size:18px;padding:18px" align="center" valign="middle">
                                <a href="https://app.buriti.arq.br/" title="Acessar" style="font-weight:bold;letter-spacing:-0.5px;line-height:100%;text-align:center;     border-collapse: separate!important;    border-radius: 3px;   background-color: #009fc7;text-decoration:none;color:#ffffff;  display: inline-block;    padding: 16px; font-size:18px;" target="_blank">Acessar</a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                            </td>
                        </tr>
                        <tr>
                            <td style="color:#333333;">
                            <hr style="border:0; border-top: 2px solid #505050; margin:20px;font-family:Helvetica;">
                            <p style="text-align:center; font-size:16px; padding-bottom:50px;padding-top:50px;">Avenida nove de julho, 4939 - cj 141 - bloco A - Jardim paulista
                            São Paulo - SP</p>
                            <p style="text-align:center; font-size:16px; padding-bottom:20px;padding-top:20px;"><a href="https://buriti.arq.br" target="_blank" >buriti.arq.br</a></p>
                            <p style="text-align:center; font-size:16px; padding-bottom:20px">Copyright © 2020 Buriti Arquitetura, All rights reserved.</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
               </body>
            </html> ';

            $mail->send();

            // Limpa os destinat�rios e os anexos
            $mail->ClearAllRecipients();
            $mail->ClearAttachments();

            $message[] = 'Usu&aacute;rio Convidado com sucesso!';
            $code = 200;
        }

        # feedback
        $code = (!empty($code)) ? $code : 200;
        return response(['response' => $message, 'code' => $code]);
    }

    public function destroyvinculo(Request $request)
    {
        $input = $request->all();

        $results = DB::table('solicitacao')
        ->where('id_usuario', $input['idUser'])
        ->where('id_projeto', $input['idProjeto'])
        ->delete();

        if(!empty($results))
        {
            $message[] = 'Usuario Removido com Sucesso';
            $code      = 200;
        }
        else
        {
            $message[] = 'Erro ao tentar Excluir Pagamento';
            $code      = 500;
        }

        # feedback
        $code = (!empty($code)) ? $code : 200;
        return response(['response' => $message, 'code' => $code]);
    }

    public function edituser($id)
    {
        session_start();

        $aDados = DB::table('usuario')->find($id);
        return view('projetos.usuarios.edit')->with('dados', $aDados);
    }

    public function updateuser(Request $request)
    {
        session_start();

        $input   = $request->all();

        // CPF
        $cpf = str_replace(".","",$input['cpf']);
        $cpf = str_replace("-","",$cpf);

        // Telefone
        $telefone = str_replace("(","",$input['telefone']);
        $telefone = str_replace(")","",$telefone);
        $telefone = str_replace("-","",$telefone);
        $telefone = str_replace(" ","",$telefone);

        // Nascimento
        $nascimento = str_replace("/","",$input['nascimento']);

        // Whats
        $whats = str_replace("(","",$input['whatsapp']);
        $whats = str_replace(")","",$whats);
        $whats = str_replace("-","",$whats);
        $whats = str_replace(" ","",$whats);

        // Cep
        $cep = str_replace("-","",$input['cep']);

        $results = DB::table('usuario')
        ->where('id', $input['id'])
        ->update([  'data_nascimento'   => $input['nascimento'] ? $nascimento : '',
            'cpf'               => $input['cpf'] ? $cpf : '',
            'cep'               => $input['cep'] ? $cep : '',
            'nome'              => $input['nome'] ? $input['nome'] : '',
            'endereco'          => $input['endereco'] ? $input['endereco'] : '',
            'numero'            => $input['numero'] ? $input['numero'] : '',
            'complemento'       => $input['complemento'] ? $input['complemento'] : '',
            'bairro'            => $input['bairro'] ? $input['bairro'] : '',
            'cidade'            => $input['cidade'] ? $input['cidade'] : '',
            'telefone'          => $input['telefone'] ? $telefone : '',
            'whatsapp'          => $input['whatsapp'] ? $whats : '',
            'estado'            => $input['estado'] ? $input['estado'] : '',
            'senha'             => $input['senha'],
            'usuario_alteracao' => $_SESSION['id'],
            'data_alteracao'    => date("Y-m-d H:i:s")
        ]);

        if(!empty($results))
        {
            $message[] = 'Usu&aacute;rio alterado com sucesso!';
            $code = 200;
            $redirect = '/minha-conta/'.$input['id'];
        }
        else
        {
            $message[] = 'Erro ao tentar alterar usu&aacute;rio';
            $code = 500;
            $redirect = '';
        }

        # feedback
        $code = (!empty($code)) ? $code : 200;
        return response(['response' => $message, 'code' => $code, 'redirect' => $redirect]);
    }
}
