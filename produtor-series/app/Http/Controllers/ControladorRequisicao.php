<?php

namespace App\Http\Controllers;

use App\Http\Service\ListarEventosService;
use App\Http\Service\ProdutorSeries;
use App\Http\Service\RegistrarEventoService;
use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ControladorRequisicao
{

    protected $produtorSeries;

    public function __construct(ProdutorSeries $produtorSeries)
    {
        $this->produtorSeries = $produtorSeries;
    }

    public function executar(Request $request)
    {
       $eventos = $this->produtorSeries->executar($request->all());

       return response($eventos, 200, ['x-count' => count($eventos)]);
    }
}
