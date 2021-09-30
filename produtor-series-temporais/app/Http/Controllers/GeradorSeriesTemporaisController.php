<?php
namespace App\Http\Controllers;

use App\Http\Service\GeradorSeriesTemporaisService;
use Illuminate\Http\Request;

class GeradorSeriesTemporaisController
{

    protected $servico;

    public function __construct(GeradorSeriesTemporaisService $servico)
    {
        $this->servico = $servico;
    }

    public function executar(Request $request)
    {
        return $this->servico->executar($request->all());
    }
}
