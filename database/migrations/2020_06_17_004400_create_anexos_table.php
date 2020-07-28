<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnexosTable extends Migration
{
    public function up()
    {
        Schema::create('anexos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('descricao', 500);
            $table->integer('id_categoria');
            $table->string('documento', 100)->nullable();
            $table->string('arquivo', 500)->nullable();
            $table->string('prancha', 500);
            $table->string('escala', 500);
            $table->integer('status')->comment('0 - Pendente / 1 - Aprovado / 2 - Reprovado / 3 - Excluido')->default('0');
            $table->string('previsto', 500);
            $table->string('link', 500)->nullable();
            $table->string('detalhe', 900);
            $table->integer('id_projeto');
            $table->integer('usuario_inclusao')->nullable();
            $table->dateTime('data_inclusao')->nullable();
            $table->integer('usuario_alteracao')->nullable();
            $table->dateTime('data_alteracao')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('anexos');
    }
}
