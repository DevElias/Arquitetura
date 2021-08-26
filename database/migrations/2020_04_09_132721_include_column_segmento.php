<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IncludeColumnSegmento extends Migration
{
    
    public function up()
    {
        Schema::table('empresa',function($t){
            $t->string('segmento', 100)->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('empresa',function($t){
            $t->dropColumn('segmento');
        });
    }
}
