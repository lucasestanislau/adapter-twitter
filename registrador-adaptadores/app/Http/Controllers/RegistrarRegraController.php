<?php

namespace App\Http\Controllers;

use App\Models\Regra;
use Illuminate\Http\Request;

class RegistrarRegraController
{

    public function __construct()
    {
    }

    public function executar(Request $request)
    {
        $atributos = $request->all();
        $atributos['token'] = md5($atributos['codigoRegra']);
        $atributos['atributos'] = json_encode($atributos['atributos']);
        $regra = Regra::create($atributos);

        return $regra->token;
        /*
        if (validator($request->all(), Regra::regrasValidacao(), Regra::regrasValidacaoMensagens())->validate()) {

            if ($this->validarAtributos($request->all())) {
                return Regra::create($request->all());
            }
        } else {
            return 'A regra não passou na validação';
        }*/
    }

    public function validarAtributos($atributos)
    {
        $campos = explode("|", $atributos['nomeCampos']);
        $tipos = explode("|", $atributos['tipoCampos']);

        if (count($campos) !== count($tipos)) {
            return false;
        }

        return true;
    }
}
