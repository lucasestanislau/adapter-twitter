<?php

namespace App\Http\Controllers;

use App\Http\Validators\RegistrarEventoRequestValidator;
use App\Jobs\RegistrarEventoQueue;
use App\Models\Evento;
use Illuminate\Http\Request;

class RegistrarEventoController
{
    protected $validador;

    public function __construct(RegistrarEventoRequestValidator $validador)
    {
        $this->validador = $validador;
    }

    public function executar(Request $request)
    {
        $regra = $this->validador->executar($request->all());

        if ($regra !== null) {
            $queue = new RegistrarEventoQueue($request->all(), $regra);
            $queue->handle();
        }
        return;
    }
}
