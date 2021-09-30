<?php

namespace App\Http\Validators;

use App\Models\Regra;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class RegistrarEventoRequestValidator
{

    public function executar($atributos)
    {
        if (!isset($atributos['codigo_regra'])) {
            throw new BadRequestHttpException('Você não identificou o parâmetro codigo_regra');
        }

        $regra = Regra::where([ 'codigoRegra' => $atributos['codigo_regra']])->first();

        if ($regra == null) {
            throw new BadRequestHttpException('Regra não encontrada');
        }

        if ($this->validarAtributosRegra($atributos, $regra)) {
            return $regra;
        } else {
            throw new BadRequestHttpException('Os campos não passaram na validação');
        }

        return null;
    }

    private function validarAtributosRegra($atributos, Regra $regra)
    {
        $campos = explode("|", $regra->nomeCampos);
        foreach ($campos as $campo) {
            if (!array_key_exists($campo, $atributos)) {
                return false;
            }
        }

        return true;
    }
}
