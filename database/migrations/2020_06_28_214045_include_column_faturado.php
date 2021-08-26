<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IncludeColumnFaturado extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orcamento', function (Blueprint $table) {
            $table->string('faturado', 10)->comment('Item faturado S ou N')->after('id_tipo')->default('N');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orcamento',function($t){
            $t->dropColumn('faturado');
        });
    }
}
