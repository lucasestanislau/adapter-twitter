<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class Evento extends Model
{
    protected $table = "eventos";

    protected $increments = true;
    protected $fillable = [
        'regra_id', 'latitude', 'longitude', 'cidade', 'dataHora', 'codigo', 'valorNumero', 'valorTexto', 'json'
    ];

    public function regra(){
        $this->hasOne('regras', 'regra_id', 'id');
    }
}
