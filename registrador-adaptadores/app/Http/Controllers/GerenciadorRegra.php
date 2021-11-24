<?php

namespace App\Http\Controllers;

use App\Models\Regra;
use Illuminate\Http\Request;

class GerenciadorRegra
{
    public function registrarRegra(Request $request)
    {
        $atributos = $request->all();
        $atributos['token'] = $this->gerarToken($atributos['codigoRegra']);
        $atributos['atributos'] = json_encode($atributos['atributos']);
        $regra = Regra::create($atributos);

        return $regra->token;
    }

    public function gerarToken($texto)
    {
        return md5($texto);
    }
}
