<?php

namespace App\Http\Controllers;

use App\Http\Service\ListarEventosService;
use App\Http\Service\RegistrarEventoService;
use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ListarEventosController
{

    protected $servico;

    public function __construct(ListarEventosService $servico)
    {
        $this->servico = $servico;
    }

    public function executar(Request $request)
    {
       $eventos = $this->servico->executar($request->all());

       return response($eventos, 200, ['x-count' => count($eventos)]);
    }
}
