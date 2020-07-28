<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReuniaoTable extends Migration
{
    public function up()
    {
        Schema::create('reuniao', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('titulo', 500);
            $table->integer('id_categoria');
            $table->string('data', 100);
            $table->string('hora_inicio', 100);
            $table->string('hora_fim', 100);
            $table->string('localizacao', 500);
            $table->string('descricao', 900);
            $table->string('texto_adicional', 900);
            $table->integer('id_projeto');
            $table->integer('usuario_inclusao')->nullable();
            $table->dateTime('data_inclusao')->nullable();
            $table->integer('usuario_alteracao')->nullable();
            $table->dateTime('data_alteracao')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reuniao');
    }
}
