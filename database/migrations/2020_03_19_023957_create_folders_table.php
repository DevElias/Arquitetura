<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoldersTable extends Migration
{
    public function up()
    {
        Schema::create('pasta', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('id_random', 100)->comment('id randomico das pastas gerado para identificar a url verdadeira');
            $table->string('id_empresa', 10);
            $table->string('descricao', 100);
            $table->integer('tipo')->comment('0 - Pasta / 1 - Arquivo');
            $table->string('url', 500);
            $table->string('breadcrumbs', 100);
            $table->string('extend_random', 100)->comment('id dos filhos');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pasta');
    }
}
