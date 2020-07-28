<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentosTable extends Migration
{
  
    public function up()
    {
        Schema::create('documentos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('descricao', 500);
            $table->string('documento', 500)->nullable();
            $table->string('link', 500)->nullable();
            $table->integer('status')->comment('0 - Pendente / 1 - Aprovado / 2 - Reprovado / 3 - Excluido')->default('0');
            $table->string('arquivo', 500)->nullable();
            $table->integer('id_projeto');
            $table->integer('id_reuniao');
            $table->integer('usuario_inclusao')->nullable();
            $table->dateTime('data_inclusao')->nullable();
            $table->integer('usuario_alteracao')->nullable();
            $table->dateTime('data_alteracao')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('documentos');
    }
}
