<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class EnviaEventosPluviometrico extends Controller
{
    const urlIntegradorFontes = 'http://localhost:3333/integrador-fontes';

    public static function enviarParaIntegradorFontes($eventoPluviometricoTratado){
        return Http::post(self::urlIntegradorFontes, $eventoPluviometricoTratado);
    }
}
