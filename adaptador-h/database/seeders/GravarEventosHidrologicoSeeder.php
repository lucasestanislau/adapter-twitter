<?php

namespace Database\Seeders;

use App\Models\Evento;
use App\Models\Middleware;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class GravarEventosHidrologicoSeeder extends Seeder
{
    const URL_INTEGRADOR_FONTES = 'http://localhost:3333/integrador-fontes';
    const URL_CEMADEN_HIDROLOGICO = 'http://200.133.244.152/WsParceiro/CEMADEN/resources/parceiros/SP/3';

    public function run()
    {
        $count = 0;
        $expect = 10;
        while ($count < $expect) {
            $dadosApi = json_decode(file_get_contents(self::URL_CEMADEN_HIDROLOGICO));

            foreach ($dadosApi->cemaden as $evento) {

                if (!$evento->nivel) {
                    continue;
                }

                $fields = [
                    'token' => '0a23b2bf028ca72e4ae2808962bf6ec6',
                    'codigo_regra'      => 'cemaden-hidrologico',
                    'codestacao'         => $evento->codestacao,
                    'latitude'         => $evento->latitude,
                    'longitude'         => $evento->longitude,
                    'cidade'         => $evento->cidade,
                    'uf'         => $evento->uf,
                    'nome'         => $evento->nome,
                    'dataHora'         => $evento->dataHora,
                    'chuva'         => $evento->chuva ? $evento->chuva : '',
                    'nivel'         => $evento->nivel ?? '',
                    'tipo'         => $evento->tipo,
                ];
                $response = Http::post(self::URL_INTEGRADOR_FONTES, $fields);
            }

            $count++;
            sleep(600);
        }
    }
}
