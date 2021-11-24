<?php

namespace App\Http\Service;

use App\Models\Evento;
use App\Models\Regra;
use DateTime;

class ProdutorSeries
{

    public function executar($atributos)
    {
        if (isset($atributos['regras_ids'])) {
            $idsRegras = explode(',', $atributos['regras_ids']);

            $retorno = [];

            $countRegra = 0;
            foreach ($idsRegras as $idRegra) {

                $agrupador = $atributos['agrupador'];
                $dataInicio = $atributos['data_inicio'];
                $dataFim = $atributos['data_fim'] ?? null;
                $palavraChave = $atributos['palavra_chave'] ?? null;
                $cidade = $atributos['cidade'];
                $estado = $atributos['estado'];

                $regraCadastrada = Regra::find($idRegra);

                if ($regraCadastrada->campoReferenciaTexto !== null) {

                    $this->getEventosFrequenciaTexto($palavraChave, $dataInicio, $dataFim, $regraCadastrada, $agrupador, $retorno, $countRegra, $cidade, $estado);
                } else if ($regraCadastrada->campoReferenciaNumero !== null) {

                    $this->getEventosMediaNumerico($dataInicio, $dataFim, $regraCadastrada, $agrupador, $retorno, $countRegra, $cidade, $estado);
                }

                $countRegra++;
            }
            return (array) $retorno;
        } else {
            dd("a regra deve ser passada como parâmetro");
        }
    }

    private function calcularMediaArray($arr)
    {
        $soma = 0;
        foreach ($arr as $ar) {
            if ($ar != '' && $ar != null)
                $soma += $ar;
        }

        return $soma > 0 ? $soma / count($arr) : 0;
    }

    private function getEventosMediaNumerico($dataInicio, $dataFim, $regra, $agrupador, &$retorno, $countRegra, $cidade, $estado)
    {
        $eventos = null;
        if ($agrupador === 'hora') {

            $eventos =  Evento::where('regra_id', $regra->id)
                ->whereDate('dataHora', '=', $dataInicio)
                ->where(['cidade' => $cidade])
                ->where(['estado' => $estado])
                ->get();


            $retorno[$countRegra]['regra_id'] = $regra->id;
            $retorno[$countRegra]['adaptador'] = $regra->nomeAdaptador;
            $retorno[$countRegra]['codigoRegra'] = $regra->codigoRegra;

            for ($i = 0; $i < 24; $i++) {
                $valoresEncontrados = [];
                foreach ($eventos as $evento) {
                    $date = new DateTime();
                    $date->setTimestamp(strtotime($evento->dataHora));
                    if (intval($date->format('H')) == $i) {
                        $valoresEncontrados[] = $evento->valorNumero;
                    }
                }

                $media = $this->calcularMediaArray($valoresEncontrados);
                $retorno[$countRegra]['dados'][] = ['index' => sprintf('%02d', $i) . ':00', 'valor' => $media];
            }
        } else if ($agrupador === 'dia') {
            $retorno[$countRegra]['regra_id'] = $regra->id;
            $retorno[$countRegra]['adaptador'] = $regra->nomeAdaptador;
            $retorno[$countRegra]['codigoRegra'] = $regra->codigoRegra;

            $start = strtotime($dataInicio);
            $end = strtotime($dataFim);

            $days_between = ceil(abs($end - $start) / 86400);

            for ($i = 0; $i <= $days_between; $i++) {
                $valoresEncontrados = [];
                $date = new DateTime();
                $date->setTimestamp(strtotime($dataInicio));

                date_add($date, date_interval_create_from_date_string($i . ' days'));

                $eventos =  Evento::where('regra_id', $regra->id)
                    ->whereDate('dataHora', '=', $date->format('Y-m-d'))
                    ->where(['cidade' => $cidade])
                    ->where(['estado' => $estado])
                    ->get();

                foreach ($eventos as $evento) {
                    $valoresEncontrados[] = $evento->valorNumero;
                }

                $media = $this->calcularMediaArray($valoresEncontrados);
                $retorno[$countRegra]['dados'][] = ['index' => $date->format('d-m'), 'valor' => $media];
            }
        }
    }


    private function getEventosFrequenciaTexto($palavraChave, $dataInicio, $dataFim, $regra, $agrupador, &$retorno, $countRegra, $cidade, $estado)
    {

        $eventos = null;
        if ($agrupador === 'hora') {
            $eventos =  Evento::where('regra_id', $regra->id)
                ->whereDate('dataHora', '=', $dataInicio)
                ->where('valorTexto', 'like', '%' . $palavraChave . '%')
                ->where(['cidade' => $cidade])
                ->where(['estado' => $estado])
                ->get();

            $retorno[$countRegra]['regra_id'] = $regra->id;
            $retorno[$countRegra]['adaptador'] = $regra->nomeAdaptador;
            $retorno[$countRegra]['codigoRegra'] = $regra->codigoRegra;
            $retorno[$countRegra]['palavraChave'] = $palavraChave;
            $retorno[$countRegra]['dataInicio'] = $dataInicio;

            for ($i = 0; $i < 24; $i++) {
                $valoresEncontrados = [];
                foreach ($eventos as $evento) {
                    $date = new DateTime();
                    $date->setTimestamp(strtotime($evento->dataHora));
                    if (intval($date->format('H')) == $i) {
                        $valoresEncontrados[] = $evento->valorTexto;
                    }
                }

               
                $retorno[$countRegra]['dados'][] = ['index' => sprintf('%02d', $i) . ':00', 'valor' => count($valoresEncontrados)];
            }
            return;
        } else if ($agrupador === 'dia') {
            $eventos =  Evento::where('regra_id', $regra->id)
                ->whereDate('dataHora', '>=', $dataInicio)
                ->whereDate('dataHora', '<=', $dataFim)
                ->where(['cidade' => $cidade])
                ->where(['estado' => $estado])
                ->where('valorTexto', 'like', '%' . $palavraChave . '%')
                ->get();

            $retorno[$countRegra]['regra_id'] = $regra->id;
            $retorno[$countRegra]['adaptador'] = $regra->nomeAdaptador;
            $retorno[$countRegra]['codigoRegra'] = $regra->codigoRegra;
            $retorno[$countRegra]['palavraChave'] = $palavraChave;

            $start = strtotime($dataInicio);
            $end = strtotime($dataFim);

            $days_between = ceil(abs($end - $start) / 86400);

            for ($i = 0; $i <= $days_between; $i++) {
                $valoresEncontrados = [];
                $date = new DateTime();
                $date->setTimestamp(strtotime($dataInicio));

                date_add($date, date_interval_create_from_date_string($i . ' days'));
                foreach ($eventos as $evento) {

                    if (date('d', strtotime($evento->dataHora)) == intval($date->format('d'))) {
                        $valoresEncontrados[] = $evento->valorTexto;
                    }
    
                }

                $retorno[$countRegra]['dados'][] = ['index' => $date->format('d-m'), 'valor' => count($valoresEncontrados)];
            }
        }
    }
}
