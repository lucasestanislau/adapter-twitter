<?php

use App\Models\Localizacao;
use Illuminate\Http\Request;

$router->get('/', function () use ($router) {
    return $router->app->version();
});
/**
 * Esse componente é o registrador de adaptadores
 * 
 */
//$router->post('/eventos', RegistrarEventoController::class . '@executar');
$router->post('/registrar-adaptador', RegistrarRegraController::class . '@executar');
//$router->get('/localizacoes', LocalizacoesController::class . '@executar');
$router->get('/localizacoes-banco', Controller::class . '@setLocalizacoes');
