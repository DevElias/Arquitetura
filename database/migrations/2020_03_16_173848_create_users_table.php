<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('usuario', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nome', 100);
            $table->string('email', 100)->unique();
            $table->string('senha', 100);
            $table->string('cpf', 12)->unique();
            $table->string('data_nascimento', 12);
            $table->string('telefone', 100);
            $table->string('whatsapp', 100)->nullable();;
            $table->string('cep', 8);
            $table->string('endereco', 100);
            $table->string('numero', 100);
            $table->string('complemento', 100)->nullable();;
            $table->string('bairro', 100);
            $table->string('cidade', 100);
            $table->string('estado', 100);
            $table->integer('tipo_usuario')->comment('0 - Administrador / 1 - Normal')->default('1');
            $table->integer('status')->comment('0 - Inativo / 1 - Ativo')->default('1');
            $table->integer('usuario_inclusao')->nullable();
            $table->dateTime('data_inclusao')->nullable();
            $table->integer('usuario_alteracao')->nullable();
            $table->dateTime('data_alteracao')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('usuario');
    }
}
