<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Http;

class Controller extends BaseController
{
    const TOKEN = "c2c44284ee457a116ea7c8b067f99a3a";
    const URL_INTEGRADOR_FONTES = 'http://localhost:3333/integrador-fontes';
    const URL_CEMADEN_PLUVIOMETRICO = 'http://200.133.244.152/WsParceiro/CEMADEN/resources/parceiros/SP/1';

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function enviarObservacoesIntegradorFontes(Request $request)
    {
        //$count = 0;
        //$expect = 10;
        // while ($count < $expect) {
        $dadosApi = json_decode(file_get_contents(self::URL_CEMADEN_PLUVIOMETRICO));

        foreach ($dadosApi->cemaden as $evento) {

            $fields = [
                'token' => self::TOKEN,
                'codigo_regra'      => 'cemaden-pluviometrica',
                'codestacao'         => $evento->codestacao,
                'latitude'         => $evento->latitude,
                'longitude'         => $evento->longitude,
                'cidade'         => $evento->cidade,
                'dataHora'         => $evento->dataHora,
                'chuva'         => $evento->chuva ? $evento->chuva : '',
                'tipo'         => $evento->tipo,
            ];

            $response = Http::post(self::URL_INTEGRADOR_FONTES, $fields);

            print_r($response);

            exit();
        }

        //  $count++;
        //  sleep(600);
        //}
    }
}
