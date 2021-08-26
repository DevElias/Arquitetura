<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/dashboard-admin', ['uses' => 'DashboardController@index']);
Route::get('/dashboard-cliente', ['uses' => 'DashboardController@cliente']);
// Route::view('/', 'starter')->name('starter');
Route::get('large-compact-sidebar/starter/blank-compact', function () {
    // set layout sesion(key)
    session(['layout' => 'compact']);
    return view('starter.blank-compact');
})->name('compact');

Route::get('large-sidebar/starter/blank-large', function () {
    // set layout sesion(key)
    session(['layout' => 'normal']);
    return view('starter.blank-large');
})->name('normal');

Route::get('horizontal-bar/starter/blank-horizontal', function () {
    // set layout sesion(key)
    session(['layout' => 'horizontal']);
    return view('starter.blank-horizontal');
})->name('horizontal');

Route::get('vertical/starter/blank-vertical', function () {
    // set layout sesion(key)
    session(['layout' => 'vertical']);
    return view('starter.blank-vertical');
})->name('vertical');


Route::get('/aprovacoes/empresas', 'EmpresaController@aprovacoes');
Route::get('/aprovacoes/clientes', 'EmpresaController@aprovacliente');
Route::get('/aprovacoes/usuarios', 'UsuarioController@listausuario');
Route::get('/projeto', 'ProjetoController@index');
Route::view('/projeto/novo', 'projetos.novo')->name('novo');

 // sessions
 Route::view('/', 'sessions.login')->name('login');
 Route::view('/cadastro', 'sessions.cadastro')->name('cadastro');
 Route::view('/esqueci', 'sessions.esqueci')->name('esqueci');
 Route::view('/404', 'dashboard.404')->name('404');

 //User Actions
 Route::post('/cadastrar', ['uses' => 'UsuarioController@create']);
 Route::post('/login', ['uses' => 'UsuarioController@login']);
 Route::get('/logout', ['uses' => 'UsuarioController@logout']);
 Route::post('/notificacoes', ['uses' => 'UsuarioController@notificacoes']);
 Route::post('/atualiza/notificacoes', ['uses' => 'UsuarioController@atualizanotificacoes']);
 Route::get('/minha-conta/{id}', ['uses' => 'UsuarioController@profile']);
 Route::post('/atualizar', ['uses' => 'UsuarioController@update']);
 Route::post('/enviar/senha', ['uses' => 'UsuarioController@esqueci']);
 Route::post('/aprovar/usuario', ['uses' => 'UsuarioController@aprovar']);
 Route::post('/reprovar/usuario', ['uses' => 'UsuarioController@reprovar']);

 //Projects
 Route::post('/lista/projeto', ['uses' => 'ProjetoController@index']);
 Route::post('/cadastrar/projeto', ['uses' => 'ProjetoController@create']);
 Route::post('/buscar/projeto', ['uses' => 'ProjetoController@search']);
 Route::get('/projeto/{id}/status', ['uses' => 'ProjetoController@show']);
 Route::post('/projeto/get', ['uses' => 'ProjetoController@get']);
 Route::get('/atualizar/{id}/projeto', ['uses' => 'ProjetoController@edit']);
 Route::post('/atualizar/projeto/{id}', ['uses' => 'ProjetoController@update']);

 //Cronogramas
 Route::get('/projeto/{id}/cronogramas', ['uses' => 'CronogramaController@index']);
 Route::get('/projeto/{id}/cronogramas/{id2}/detalhes', ['uses' => 'CronogramaController@detalhe']);
 Route::post('/cadastrar/cronograma', ['uses' => 'CronogramaController@create']);
 Route::post('/cadastrar/cronograma/itens', ['uses' => 'CronogramaController@createitens']);
 Route::post('/excluir/cronograma/itens/{id}', ['uses' => 'CronogramaController@destroyitens']);
 Route::post('/editar/cronograma/itens/{id}', ['uses' => 'CronogramaController@edititens']);
 Route::post('/atualizar/cronograma/itens/{id}', ['uses' => 'CronogramaController@updateitens']);
 Route::post('/atualizar/cronograma', ['uses' => 'CronogramaController@update']);
 Route::post('/busca/cronograma/{id}', ['uses' => 'CronogramaController@busca']);

//Financeiro
Route::get('/projeto/{id}/financeiro', ['uses' => 'FinanceiroController@index']);
Route::get('/projeto/{id}/financeiro/agenda', ['uses' => 'FinanceiroController@agenda']);
Route::get('/projeto/{id}/financeiro/novo', ['uses' => 'FinanceiroController@novo']);
Route::post('/cadastrar/financeiro', ['uses' => 'FinanceiroController@create']);
Route::post('/upload/financeiro', ['uses' => 'FinanceiroController@upload']);
Route::get('/listagem/financeiro/{id}', ['uses' => 'FinanceiroController@listagem']);
Route::get('/projeto/{id}/financeiro/detalhes/{id2}', ['uses' => 'FinanceiroController@detalhes']);
Route::get('/projeto/{id}/financeiro/editar/{id2}', ['uses' => 'FinanceiroController@editar']);
Route::post('/excluir/financeiro/{id}', ['uses' => 'FinanceiroController@destroy']);
Route::post('/atualizar/financeiro/{id}', ['uses' => 'FinanceiroController@update']);
Route::get('/projeto/{id}/financeiro/novo/{id2}', ['uses' => 'FinanceiroController@novofaturado']);
Route::post('/cadastrar/financeiro/orcamento', ['uses' => 'FinanceiroController@createfinanceirorc']);
Route::post('/excluir/financeiro/orcamento/{id}', ['uses' => 'FinanceiroController@destroyfinanceiroorcamento']);
Route::get('/projeto/{id}/financeiro/fluxodecaixa', ['uses' => 'FinanceiroController@fluxodecaixa']);

//Usuario Projeto
Route::get('/projeto/{id}/usuarios', ['uses' => 'UsuarioController@usuarioprojeto']);
Route::post('/enviar/convite', ['uses' => 'UsuarioController@convite']);
Route::post('/excluir/vinculo', ['uses' => 'UsuarioController@destroyvinculo']);
Route::get('/edit/usuario/{id}/projeto/{id2}', ['uses' => 'UsuarioController@edituser']);
Route::post('/atualizar/user', ['uses' => 'UsuarioController@updateuser']);

//Reuniões
Route::get('/projeto/{id}/reunioes', ['uses' => 'ReunioesController@index']);
Route::get('/projeto/{id}/reunioes/detalhes/{id2}', ['uses' => 'ReunioesController@detalhes']);
Route::get('/projeto/{id}/reunioes/novo', ['uses' => 'ReunioesController@novo']);
Route::post('/cadastrar/reuniao', ['uses' => 'ReunioesController@create']);
Route::post('/confirmar/reuniao/{id}', ['uses' => 'ReunioesController@confirm']);
Route::post('/rejeitar/reuniao/{id}', ['uses' => 'ReunioesController@decline']);
Route::get('/projeto/{id}/reunioes/detalhes/{id2}/editar', ['uses' => 'ReunioesController@edit']);
Route::post('/atualizar/reuniao/{id}', ['uses' => 'ReunioesController@update']);
Route::post('/upload/arquivo/reuniao', ['uses' => 'ReunioesController@upload']);
Route::post('/gravar/documento', ['uses' => 'ReunioesController@gravardocumento']);
Route::get('/listagem/reuniao/{id}', ['uses' => 'ReunioesController@listagem']);
Route::post('/aprovar/documento/{id}', ['uses' => 'ReunioesController@aprovar']);
Route::post('/reprovar/documento/{id}', ['uses' => 'ReunioesController@reprovar']);
Route::post('/excluir/documento/{id}', ['uses' => 'ReunioesController@excluir']);
Route::post('/editar/documento/{id}', ['uses' => 'ReunioesController@editardoc']);
Route::post('/atualizar/documento', ['uses' => 'ReunioesController@atualizar']);

//Notificações
Route::get('/projeto/{id}/notificacoes', ['uses' => 'NotificacoesController@index']);
Route::get('/projeto/{id}/notificacoes/novo', ['uses' => 'NotificacoesController@novo']);
Route::post('/cadastrar/notificacao', ['uses' => 'NotificacoesController@create']);
Route::post('/upload/notificacao', ['uses' => 'NotificacoesController@upload']);
Route::post('/excluir/notificacao/{id}', ['uses' => 'NotificacoesController@destroy']);
Route::get('/projeto/{id}/notificacao/editar/{id2}', ['uses' => 'NotificacoesController@edit']);
Route::post('/atualizar/notificacao/{id}', ['uses' => 'NotificacoesController@update']);

//Anexos (Projetos)
Route::get('/projeto/{id}/anexos', ['uses' => 'AnexosController@index']);
Route::get('/projeto/{id}/anexos/novo', ['uses' => 'AnexosController@novo']);
Route::post('/cadastrar/anexo', ['uses' => 'AnexosController@create']);
Route::post('/upload/anexo', ['uses' => 'AnexosController@upload']);
Route::post('/excluir/anexo/{id}', ['uses' => 'AnexosController@destroy']);
Route::get('/projeto/{id}/anexos/editar/{id2}', ['uses' => 'AnexosController@edit']);
Route::post('/atualizar/anexo/{id}', ['uses' => 'AnexosController@update']);

//Orçamentos
Route::get('/projeto/{id}/orcamentos', ['uses' => 'OrcamentosController@index']);
Route::get('/projeto/{id}/orcamentos/listagem/', ['uses' => 'OrcamentosController@orcamentoslistagem']);
Route::get('/projeto/{id}/orcamentos/produtos/', ['uses' => 'OrcamentosController@orcamentosprodutos']);
Route::get('/projeto/{id}/orcamentos/produtos/novo', ['uses' => 'OrcamentosController@orcamentosprodutosnovo']);
Route::get('/projeto/{id}/orcamentos/servicos/', ['uses' => 'OrcamentosController@orcamentosservicos']);
Route::get('/projeto/{id}/orcamentos/servicos/novo', ['uses' => 'OrcamentosController@orcamentosservicosnovo']);
Route::post('/cadastrar/orcamento/produto', ['uses' => 'OrcamentosController@createproduto']);
Route::post('/cadastrar/orcamento/servico', ['uses' => 'OrcamentosController@createservico']);
Route::post('/cadastrar/orcamento/itemaprovado', ['uses' => 'OrcamentosController@itemaprovado']);
Route::post('/upload/orcamento/imagemorcamento', ['uses' => 'OrcamentosController@imagemorcamento']);
Route::post('/excluir/orcamento/itens/{id}', ['uses' => 'OrcamentosController@destroyitens']);
Route::post('/editar/orcamento/itens/{id}', ['uses' => 'OrcamentosController@edititens']);
Route::post('/atualizar/orcamento/itens/{id}', ['uses' => 'OrcamentosController@updateitens']);
Route::post('/aprovar/orcamento/produto/', ['uses' => 'OrcamentosController@aprovarProduto']);
Route::post('/reprovar/orcamento/produto', ['uses' => 'OrcamentosController@reprovarProduto']);
Route::post('/excluir/orcamento/itenspai/{id}', ['uses' => 'OrcamentosController@destroyitenspai']);
Route::get('/projeto/{id}/orcamentos/produtos/editar/{id2}', ['uses' => 'OrcamentosController@updatePergProdutos']);
Route::get('/projeto/{id}/orcamentos/servicos/editar/{id2}', ['uses' => 'OrcamentosController@updatePergServicos']);
Route::post('/atualizar/orcamento/itens/lote/{id}', ['uses' => 'OrcamentosController@updateitenslote']);
Route::get('/projeto/{id}/orcamentos/excel/', ['uses' => 'OrcamentosController@orcamentosexcel']);

 //Custom Projetos
 Route::get('/empresa/{id}/status', ['uses' => 'EmpresaController@status']);


 Route::get('/empresa/{id}/folders/{pasta}', ['uses' => 'EmpresaController@pasta']);
 Route::post('/solicitar/empresa', ['uses' => 'EmpresaController@solicitar']);
 Route::post('/responsavel/empresa', ['uses' => 'EmpresaController@responsavel']);
 Route::post('/addusuario/empresa', ['uses' => 'EmpresaController@addusuario']);
 Route::post('/atualizar/empresa', ['uses' => 'EmpresaController@update']);
 //Folders
 Route::post('/criar/pasta', ['uses' => 'EmpresaController@criarpasta']);
 Route::post('/envia/arquivo', ['uses' => 'EmpresaController@arquivo'])->name('envia.arquivo');
 //Requests
 Route::post('/aprovar/solicitacao', ['uses' => 'EmpresaController@aprovarsolicitacao']);
 Route::post('/reprovar/solicitacao', ['uses' => 'EmpresaController@reprovarsolicitacao']);

//dados
Route::get('/dados/clientes', ['uses' => 'DadosController@index']);
Route::get('/dados/projetos', ['uses' => 'DadosController@projetos']);

//Categorias
Route::get('/categorias', ['uses' => 'CategoriasController@index']);
Route::post('/cadastrar/categoria', ['uses' => 'CategoriasController@create']);
Route::post('/eliminar/categoria/{id}', ['uses' => 'CategoriasController@destroy']);
Route::post('/editar/categoria/{id}', ['uses' => 'CategoriasController@edit']);
Route::post('/atualizar/categoria', ['uses' => 'CategoriasController@update']);
