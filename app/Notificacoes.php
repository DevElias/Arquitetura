<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notificacoes extends Model
{
    public    $timestamps = false;
    protected $table      = 'notificacoes';
    protected $primaryKey = 'id';
    
    const data_inclusao  = 'creation_date';
    const data_alteracao = 'last_update';
}
