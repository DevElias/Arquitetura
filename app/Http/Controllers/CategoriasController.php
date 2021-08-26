<?php

namespace App\Http\Controllers;

use App\Categoria;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\DB;

class CategoriasController extends Controller
{
    public function __construct()
    {
        session_start();
    }
    
    public function index()
    {
        //Apenas Categorias Ativas
        $aCategorias = DB::table('categoria')->where('categoria.status', '!=', '0')->get();
        
        return view('categorias.index')->with('categorias', $aCategorias);
    }

    public function create(Request $request)
    {
        $input     = $request->all();
        $categoria = new Categoria;
        $i         = 1;
        
        foreach($request['vinculos'] as $vinculo)
        {
            if($i == 1)
            {
                $ids = $vinculo;
            }
            else 
            {
                $ids = $ids . ',' . $vinculo;
            }
            
            $i++;
        }
        
        $categoria->nome              = $input['nome'];
        $categoria->id_vinculos        = $ids;
        $categoria->status            = '1'; // Ativo
        $categoria->data_inclusao     = date('Y-m-d H:i:s');
        $categoria->usuario_inclusao  = $_SESSION['id'];
        $categoria->usuario_alteracao = '0';
        
        try
        {
            $categoria->save();
            
            if($categoria->wasRecentlyCreated == 1)
            {
                $message[] = 'Categoria cadastrada com sucesso!';
                $code      = 200;
                $redirect  = '/categorias';
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
        $aCategoria = DB::table('categoria')->where('categoria.id', '=', $id)->get();
        
        # feedback
        $code = (!empty($code)) ? $code : 200;
        return response()->json(array('response' => $aCategoria));
    }

    public function update(Request $request)
    {
        $input   = $request->all();
        $i       = 1;
        
        foreach($input['vinculos'] as $vinculo)
        {
            if($i == 1)
            {
                $ids = $vinculo;
            }
            else
            {
                $ids = $ids . ',' . $vinculo;
            }
            
            $i++;
        }
        
        $results = DB::table('categoria')
        ->where('id', $input['id'])
        ->update(['nome' => $input['nome'],
                  'id_vinculos'        => $ids,
                  'usuario_alteracao'   => $_SESSION['id'],
                  'data_alteracao'      => date("Y-m-d H:i:s")
        ]);
        
        if(!empty($results))
        {
            $message[] = 'Categoria alterada com sucesso!';
            $code = 200;
            $redirect = '/categorias/';
        }
        else
        {
            $message[] = 'Erro ao tentar alterar categoria';
            $code = 500;
            $redirect = '';
        }
        
        # feedback
        $code = (!empty($code)) ? $code : 200;
        return response(['response' => $message, 'code' => $code, 'redirect' => $redirect]);
    }

    public function destroy($id)
    {
        $results = DB::table('categoria')
        ->where('id', $id)
        ->update(['status' => '0']);
        
        if(!empty($results))
        {
            $message[] = 'Categoria Excluida com Sucesso';
            $code      = 200;
            $redirect  = '/categorias';
        }
        else
        {
            $message[] = 'Erro ao tentar Excluir Categoria';
            $code      = 500;
            $redirect  = '';
        }
        
        # feedback
        $code = (!empty($code)) ? $code : 200;
        return response(['response' => $message, 'code' => $code, 'redirect' => $redirect]);
    }
}
