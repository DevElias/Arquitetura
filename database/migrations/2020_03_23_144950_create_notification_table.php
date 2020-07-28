<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationTable extends Migration
{
    public function up()
    {
        Schema::create('notificacao', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_usuario_envia');
            $table->integer('id_usuario_recebe');
            $table->string('mensagem', 500);
            $table->integer('status')->comment('0 - Nao Lido / 1 - Lido')->default('0');
            $table->dateTime('data_notificacao')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('notificacao');
    }
}
