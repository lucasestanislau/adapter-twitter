<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pluviometrico-integrar', Controller::class . '@enviarObservacoesIntegradorFontes');

Route::get('/cadastrar-regra', function (){
    $resposta = Http::post("http://localhost:8082/registrar-adaptador", [
        "codigoRegra" => "cemaden-pluviometricaaaaaa",
        "nomeFonte" => "cemaden",
        "nomeAdaptador" => "cemaden-p",
        "atributos" => [
            
            ["nome"=> "codestacao", "tipo" => "string"],
            ["nome"=> "tipo", "tipo" => "dateTime"],
            ["nome"=> "latitude", "tipo" => "number"],
            ["nome"=> "longitude", "tipo" => "number"],
            ["nome"=> "chuva", "tipo" => "number"],
            ["nome"=> "dataHora", "tipo" => "dateTime"],
            ["nome"=> "nome", "tipo" => "string"],
            ["nome"=> "uf", "tipo" => "string"],
            ["nome"=> "cidade", "tipo" => "string"]
        ],
        "campoReferenciaTexto" => null,
        "campoReferenciaNumero" => "chuva",
        "campoReferenciaDataHora" => "dataHora",
        "campoLocalizacao1" => "latitude",
        "campoLocalizacao2" => "longitude",
        "campoLocalizacao3" => "cidade",
        "campoCodigo" => "codestacao",
        "descricao" => "Regra referente ao adaptador que coleta dados do cemaden"
    ]);

    return "token: " . $resposta;
});
