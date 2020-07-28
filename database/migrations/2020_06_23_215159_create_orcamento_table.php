<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrcamentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orcamento', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_categoria');
            $table->string('id_pai', 500)->nullable();
            $table->integer('id_tipo')->comment('0 - Produto / 1 - Servico / 2 - Outros')->default('2');
            $table->string('pergunta', 500)->nullable();
            $table->string('descricao', 500);
            $table->string('unidade', 500);
            $table->float('valor', 10, 2);
            $table->float('total', 10, 2);
            $table->string('link', 500)->nullable();
            $table->string('documento', 500)->nullable();
            $table->string('adicionais', 500)->nullable();
            $table->integer('status')->comment('0 - Pendente / 1 - Aprovado / 2 - Reprovado / 3 - Excluido')->default('0');
            $table->string('motivo', 500)->nullable();
            $table->integer('id_projeto');
            $table->integer('usuario_inclusao')->nullable();
            $table->dateTime('data_inclusao')->nullable();
            $table->integer('usuario_alteracao')->nullable();
            $table->dateTime('data_alteracao')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orcamento');
    }
}
