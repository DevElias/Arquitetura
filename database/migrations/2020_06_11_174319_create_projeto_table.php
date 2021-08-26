<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjetoTable extends Migration
{
    public function up()
    {
        Schema::create('projeto', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nome', 100);
            $table->string('descricao', 900);
            $table->string('cep', 8);
            $table->string('endereco', 100);
            $table->string('numero', 100);
            $table->string('complemento', 100)->nullable();;
            $table->string('bairro', 100);
            $table->string('cidade', 100);
            $table->string('estado', 100);
            $table->integer('id_responsavel')->default('0');
            $table->integer('status')->comment('0 - Em Andamento / 1 - Concluido / 2 - Pausado / 3 - Cancelado / 4 - Excluido')->default('0');
            $table->integer('usuario_inclusao')->nullable();
            $table->dateTime('data_inclusao')->nullable();
            $table->integer('usuario_alteracao')->nullable();
            $table->dateTime('data_alteracao')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('projeto');
    }
}
