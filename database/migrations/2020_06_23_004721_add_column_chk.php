<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnChk extends Migration
{
     public function up()
    {
        Schema::table('participantes', function (Blueprint $table) {
            $table->string('chk',10)->after('status')->default('N');
        });
    }
    
    public function down()
    {
        Schema::table('participantes',function($t){
            $t->dropColumn('chk');
        });
    }
}
