<?php

namespace App\Http\Service;

class GeradorSeriesTemporaisService
{
    public function executar($atributos)
    {
        if (isset($atributos['adaptador'])) {
            return
                [
                    "adaptador" => "twitter-adaptador",
                    "dataInicio" => $atributos['dataInicio'],
                    "dataFim" => $atributos['dataFim'],
                    "palavrachave" => $atributos['palavraChave'],
                    "dados" => [

                        [
                            "index" => "00:00", "value" => 1,
                        ],                        [
                            "index" => "01:00", "value" => 5,
                        ],                        ["index" => "02:00", "value" => 15,],
                        ["index" => "03:00", "value" => 22,],
                        [
                            "index" => "04:00", "value" => 2,
                        ],                        ["index" => "05:00", "value" => 25,],
                        ["index" => "06:00", "value" => 26,],
                        ["index" => "07:00", "value" => 27,],
                        ["index" => "08:00", "value" => 29,],
                        ["index" => "09:00", "value" => 24,],
                        ["index" => "10:00", "value" => 23,],
                        ["index" => "11:00", "value" => 24,],
                        ["index" => "12:00", "value" => 29,],
                        ["index" => "13:00", "value" => 28,],
                        ["index" => "14:00", "value" => 29,],
                        ["index" => "15:00", "value" => 24,],
                        ["index" => "16:00", "value" => 21,],
                        ["index" => "17:00", "value" => 12,],
                        ["index" => "18:00", "value" => 210],
                        ["index" => "19:00", "value" => 21,],
                        ["index" => "20:00", "value" => 22,],
                        ["index" => "21:00", "value" => 23,],
                        ["index" => "22:00", "value" => 29,],
                        ["index" => "23:00", "value" => 28,],
                    ],
                ];
        }

        return $atributos;
    }
}
