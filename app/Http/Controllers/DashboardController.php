<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller

{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projetosAtivos = DB::table('projeto')->where('status', 0)->count();
        $projetosconcluidos = DB::table('projeto')->where('status', 1)->count();
        $usuariosAtivos = DB::table('usuario')->where('tipo_usuario', 1)->count();
        return view('dashboard.admin')->with([
            'projetosativos'        =>  $projetosAtivos,
            'projetoconcluido'     =>  $projetosconcluidos,
            'usuariosativos'        =>  $usuariosAtivos,
        ]);
    }
    public function cliente()
    {
        session_start();
        $aProjetos = DB::select("SELECT projeto.* FROM projeto inner join solicitacao on solicitacao.id_projeto = projeto.id where solicitacao.id_usuario = " . $_SESSION['id']);

            return view('dashboard.cliente')->with('projetos', $aProjetos);
    }
}
