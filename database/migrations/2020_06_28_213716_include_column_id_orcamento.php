<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IncludeColumnIdOrcamento extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('financeiro', function (Blueprint $table) {
            $table->string('id_orcamento', 100)->comment('Id de orçamento de item aprovado ou orcamento direto')->after('id_projeto')->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('financeiro',function($t){
            $t->dropColumn('id_orcamento');
        });
    }
}
