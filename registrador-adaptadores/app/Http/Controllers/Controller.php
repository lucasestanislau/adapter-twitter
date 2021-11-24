<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Exception;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function setLocalizacoes()
    {

        $count = 1;
        do {
            $eventos = Evento::whereNull('estado')->whereNull('cidade')->Limit(100)->get();

            $count = count($eventos) > 0 ? 1 : 0;

            foreach ($eventos as $evento) {

                $url = "https://nominatim.openstreetmap.org/reverse.php?lat={$evento->latitude}&lon={$evento->longitude}&zoom=18&format=jsonv2";

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
                    $evento->save();
                } catch (Exception $e) {
                    return;
                }
            }
        } while ($count > 0);
    }
}
