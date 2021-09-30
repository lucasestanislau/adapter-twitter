<?php

namespace App\Services;

use App\Models\Evento;

class RegistrarEventoService
{

    public function executar($atributos)
    {
        return Evento::create($atributos);
    }

}