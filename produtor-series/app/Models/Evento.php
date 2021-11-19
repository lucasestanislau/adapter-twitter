<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    protected $table = "eventos";

    protected $increments = true;
    protected $fillable = [
        'regra_id', 'latitude', 'longitude', 'cidade', 'dataHora', 'codigo', 'valorNumero', 'valorTexto', 'json'
    ];

    public function regra(){
        $this->hasOne(Regra::class, 'regra_id', 'id');
    }
}
