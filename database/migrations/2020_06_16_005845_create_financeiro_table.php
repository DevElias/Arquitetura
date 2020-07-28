<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinanceiroTable extends Migration
{
    public function up()
    {
        Schema::create('financeiro', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('descricao', 500);
            $table->string('valor', 500);
            $table->integer('id_categoria');
            $table->string('dia_pagamento', 100)->nullable();
            $table->string('parcelas', 100)->nullable();
            $table->string('replicar', 100)->nullable();
            $table->string('arquivo', 500)->nullable();
            $table->string('detalhe', 900)->nullable();
            $table->integer('status')->comment('0 - Em Aberto / 1 - Atrasado / 2 - Em Analise / 3 - Pago / 4 - Excluido')->default('0');
            $table->integer('id_projeto');
            $table->integer('usuario_inclusao')->nullable();
            $table->dateTime('data_inclusao')->nullable();
            $table->integer('usuario_alteracao')->nullable();
            $table->dateTime('data_alteracao')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('financeiro');
    }
}
