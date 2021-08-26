<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    public    $timestamps = false;
    protected $table      = 'usuario';
    protected $primaryKey = 'id';
    
    const data_inclusao  = 'creation_date';
    const data_alteracao = 'last_update';
}
