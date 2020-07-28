<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameColumnSolicitacao extends Migration
{
    public function up()
    {
        Schema::table('solicitacao', function(Blueprint $table)
        {
            $table->renameColumn('id_empresa', 'id_projeto');
            $table->renameColumn('data_solicitacao', 'data_convite');
        });
    }

    public function down()
    {
        //
    }
}
