<?php

namespace App\Services;

use App\Models\Regra;

class RegistrarRegraService
{

    public function executar($atributos)
    {
        return Regra::create($atributos);
    }
}
