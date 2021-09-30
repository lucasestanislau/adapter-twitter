<?php

namespace App\Http\Controllers;

use App\Http\Service\ListarRegrasService;
use Illuminate\Http\Request;

class ListarRegrasController
{

    protected $servico;

    public function __construct(ListarRegrasService $servico)
    {
        $this->servico = $servico;
    }

    public function executar(Request $request)
    {
       return $this->servico->executar();
    }
}
