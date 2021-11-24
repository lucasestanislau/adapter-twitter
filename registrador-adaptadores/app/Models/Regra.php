<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Regra extends Model
{
    protected $table = "regras";

    protected $fillable = [
        'codigoRegra', 'nomeFonte', 'nomeAdaptador', 'campoReferenciaTexto',
        'campoReferenciaNumero', 'token', 'campoReferenciaDataHora', 'campoLocalizacao1', 'campoLocalizacao2', 'campoLocalizacao3', 'descricao', 'campoCodigo', 'atributos',
    ];

    static function validacao()
    {
        return [
            'codigoRegra' => 'string|required|unique:regras,codigoRegra',
            'nomeFonte' => 'string|required',
            'nomeAdaptador' => 'string|required',
            'campoReferenciaTexto' => "string|nullable",
            'campoReferenciaNumero' => 'string|nullable',
            'campoReferenciaDataHora' => 'string|required',
            'campoLocalizacao1' => 'string|required',
            'campoLocalizacao2' => 'string|nullable',
            'campoLocalizacao3' => 'string|nullable',
            'descricao' => 'string|required',

        ];
    }

    static function regrasValidacaoMensagens()
    {
        return [
            'codigoRegra.string' => 'codigoRegra deve ser do tipo string',
            'codigoRegra.required' => 'codigoRegra é obrigatório',
            'codigoRegra.unique' => 'codigoRegra já cadastrado',
            'nomeAdaptador.string' => 'nomeAdaptador deve ser do tipo string',
            'nomeAdaptador.required' => 'nomeAdaptador é obrigatório',
            'campoReferenciaTexto.string' => 'campoReferenciaTexto deve ser do tipo string',
            'campoReferenciaNumero.string' => 'campoReferenciaNumero deve ser do tipo string',
            'campoLocalizacao1.string' => 'campoLocalizacao1 deve ser do tipo string',
            'campoLocalizacao1.required' => 'campoLocalizacao1 é obrigatório',
            'campoLocalizacao2.string' => 'campoLocalizacao2 deve ser do tipo string',
            'campoLocalizacao3.string' => 'campoLocalizacao3 deve ser do tipo string',
            'descricao.string' => 'descricao deve ser do tipo string',
            'descricao.required' => 'descricao é obrigatório',
        ];
    }
}
