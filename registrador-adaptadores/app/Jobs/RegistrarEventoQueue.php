<?php

namespace App\Jobs;

use App\Models\Evento;
use Exception;

class RegistrarEventoQueue extends Job
{
    protected $atributos, $regra;

    public function __construct($atributos, $regra)
    {
        $this->atributos = $atributos;
        $this->regra = $regra;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->registrar($this->atributos, $this->regra);
    }

    public function registrar($atributos, $regra)
    {
        $evento = new Evento();
        $evento->regra_id = $regra->id;
        if (!$atributos[$regra['campoLocalizacao2']]) {
            $evento->cidade = $atributos[$regra['campoLocalizacao1']];
        } else {
            $evento->latitude = $atributos[$regra['campoLocalizacao1']];
            $evento->longitude = $atributos[$regra['campoLocalizacao2']] ?? null;
            $evento->cidade = $atributos[$regra['campoLocalizacao3']] ?? null;
        }
        $evento->dataHora = $atributos[$regra['campoReferenciaDataHora']];
        $evento->valorNumero = $atributos[$regra['campoReferenciaNumero']] ?? null;
        $evento->valorTexto = $atributos[$regra['campoReferenciaTexto']] ?? null;
        $evento->codigo = $atributos[$regra['campoCodigo']] ?? null;

        $evento->json = $this->arrayToJson($atributos);

        //caso haja loc1 e loc2 quer dizer que existe latitude e longitude
        if ($evento->latitude && $evento->longitude) {
            //consultar geocoding passando a latitude e longitude e retornando cidade e estado
            $this->getCidadeEstado($evento, $evento->latitude, $evento->longitude);
        }

        $evento->save();

        exit();
        //$evento->refresh();
        return $evento;
    }



    //esse método deve realizar a consulta na api de geocoding
    public function getCidadeEstado(Evento &$evento, float $latitude, float $longitude)
    {

        //$url = 'https://nominatim.openstreetmap.org/reverse.php?lat=' . $latitude . '&lon=' . $longitude . '&zoom=18&format=jsonv2';
        //$url = 'https://nominatim.openstreetmap.org/reverse.php?lat=-24.6678193&lon=-53.8839559&zoom=18&format=jsonv2';

        $url = "https://nominatim.openstreetmap.org/reverse.php?lat={$latitude}&lon={$longitude}&zoom=18&format=jsonv2";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($result);

        try {
            $evento->cidade = $response->address->city;
            $evento->estado = $response->address->state;
        } catch (Exception $e) {
            return;
        }


        /* switch ($sorteado) {
            case 0:
                $evento->cidade = 'Toledo';
                $evento->estado = 'PR';
                break;
            case 1:
                $evento->cidade = 'Cascavel';
                $evento->estado = 'PR';
                break;
            case 2:
                $evento->cidade = 'São Paulo';
                $evento->estado = 'SP';
                break;
        }  */
    }

    public function arrayToJson($atributos)
    {
        return json_encode($atributos);
    }
}
