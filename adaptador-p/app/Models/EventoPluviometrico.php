<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventoPluviometrico extends Model
{
    public $codigo_regra;
    public $codestacao;
    public $latitude;
    public $cidade;
    public $uf;
    public $nome;
    public $dataHora;
    public $chuva;
    public $tipo;


    public function camposFormatados()
    {
        return  [
            'codigo_regra'      => 'cemaden-pluviometrica',
            'codestacao'         => $this->codestacao,
            'latitude'         => $this->latitude,
            'longitude'         => $this->longitude,
            'nome'         => $this->nome,
            'cidade'         => $this->cidade,
            'uf'         => $this->uf,
            'dataHora'         => $this->dataHora,
            'chuva'         => $this->chuva,
            'tipo'         => $this->tipo,
        ];
    }
}
