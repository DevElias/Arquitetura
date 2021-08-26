<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IncludeColumnEtapa extends Migration
{
    public function up()
    {
        Schema::table('projeto', function (Blueprint $table) {
            $table->integer('etapa')->comment('0 - Briefing / 1 - Projeto / 2 - Planejamento / 3 - Obra / 4 - Produção')->after('estado')->default('0');
        });
    }
    
    public function down()
    {
        Schema::table('projeto',function($t){
            $t->dropColumn('etapa');
        });
    }
}
