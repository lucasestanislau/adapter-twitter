<?php


$router->get('/series', ControladorRequisicao::class . '@executar');
$router->get('/regras', ListarRegrasController::class . '@executar');

