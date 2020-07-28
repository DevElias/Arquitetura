<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\DB;

class DadosController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $aClientes = array();
        $aClientes = DB::select('SELECT * FROM usuario');
        return view('dados.clientes')->with('clientes', $aClientes);
    }
    public function projetos()
    {
        $aProjetos = array();
        $aProjetos = DB::select('SELECT * FROM projeto');
        return view('dados.projetos')->with('projetos', $aProjetos);
    }
}
