<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IncludeColumnIdProjeto extends Migration
{
    public function up()
    {
        Schema::table('cronograma', function (Blueprint $table) {
            $table->integer('id_projeto')->nullable()->after('status');
        });
    }
    
    public function down()
    {
        Schema::table('projeto',function($t){
            $t->dropColumn('etapa');
        });
    }
}
