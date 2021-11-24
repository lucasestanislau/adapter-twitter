<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BuscaApiCemaden extends Controller
{
    const urlCemadenPluviometrico = 'http://200.133.244.152/WsParceiro/CEMADEN/resources/parceiros/SP/1';


    public static function executar(){
        return json_decode(file_get_contents(self::urlCemadenPluviometrico));
    }
}
