<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveUniqueUsers extends Migration
{
    public function up()
    {
        Schema::table('usuario', function(Blueprint $table)
        {
            $table->dropUnique('usuario_cpf_unique');
        });
    }

    public function down()
    {
        //
    }
}
