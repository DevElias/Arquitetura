<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCronogramaItemTable extends Migration
{
    public function up()
    {
        Schema::create('cronograma_item', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_cronograma');
            $table->integer('id_categoria');
            $table->string('descricao', 900);
            $table->string('inicio', 100);
            $table->string('fim', 100);
            $table->string('executor', 100)->nullable();
            $table->integer('status')->comment('0 - Em Andamento / 1 - Concluido / 2 - Pausado / 3 - Cancelado / 4 - Excluido')->default('0');
            $table->integer('usuario_inclusao')->nullable();
            $table->dateTime('data_inclusao')->nullable();
            $table->integer('usuario_alteracao')->nullable();
            $table->dateTime('data_alteracao')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('item');
    }
}
