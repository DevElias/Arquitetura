<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orcamento extends Model
{
    public    $timestamps = false;
    protected $table      = 'orcamento';
    protected $primaryKey = 'id';

    const data_inclusao  = 'creation_date';
    const data_alteracao = 'last_update';
}
