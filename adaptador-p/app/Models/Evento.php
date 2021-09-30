<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    protected $table = "eventos";

    protected $fillable = [
        'codestacao',
        'latitude',
        'longitude',
        'cidade' ,
        'dataHora',
        'chuva' ,
        'tipo' ,
    ];
    
}
