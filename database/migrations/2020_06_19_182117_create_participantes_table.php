<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParticipantesTable extends Migration
{
    public function up()
    {
        Schema::create('participantes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_reuniao');
            $table->integer('id_usuario');
            $table->string('motivo', 500)->nullable();
            $table->integer('status')->comment('0 - Pendente / 1 - Confirmado / 2 - Rejeitado')->default('0');
        });
    }
    public function down()
    {
        Schema::dropIfExists('participantes');
    }
}
