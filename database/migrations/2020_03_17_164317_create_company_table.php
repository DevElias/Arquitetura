<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyTable extends Migration
{
    public function up()
    {
        Schema::create('empresa', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nome_fantasia', 100);
            $table->string('razao_social', 100);
            $table->string('cnpj', 14)->unique();
            $table->string('email', 100)->unique();
            $table->string('telefone', 100);
            $table->string('whatsapp', 100)->nullable();;
            $table->string('cep', 8);
            $table->string('endereco', 100);
            $table->string('numero', 100);
            $table->string('complemento', 100)->nullable();;
            $table->string('bairro', 100);
            $table->string('cidade', 100);
            $table->string('estado', 100);
            $table->integer('id_responsavel')->default('0');
            $table->integer('status')->comment('0 - Pendente / 1 - Aprovada / 2 - Rejeitada')->default('0');
            $table->integer('usuario_inclusao')->nullable();
            $table->dateTime('data_inclusao')->nullable();
            $table->integer('usuario_alteracao')->nullable();
            $table->dateTime('data_alteracao')->nullable();
        });
    }

  
    public function down()
    {
        Schema::dropIfExists('empresa');
    }
}
