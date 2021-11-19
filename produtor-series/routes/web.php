<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use App\Models\Evento;

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/series', ListarEventosController::class . '@executar');
$router->get('/regras', ListarRegrasController::class . '@executar');

$router->get('/simular-series-numericas', function () {

    $horarios = [
        0 => date('2021-10-20 00:01'),
        1 => date('2021-10-20 01:01'),
        2 => date('2021-10-20 02:01'),
        3 => date('2021-10-20 03:01'),
        4 => date('2021-10-20 04:01'),
        5 => date('2021-10-20 05:01'),
        6 => date('2021-10-20 06:01'),
        7 => date('2021-10-20 07:01'),
        8 => date('2021-10-20 08:01'),
        9 => date('2021-10-20 09:01'),
        10 => date('2021-10-20 10:01'),
        11 => date('2021-10-20 11:01'),
        12 => date('2021-10-20 12:01'),
        13 => date('2021-10-20 13:01'),
        14 => date('2021-10-20 14:01'),
        15 => date('2021-10-20 15:01'),
        16 => date('2021-10-20 16:01'),
        17 => date('2021-10-20 17:01'),
        18 => date('2021-10-20 18:01'),
        19 => date('2021-10-20 19:01'),
        20 => date('2021-10-20 20:01'),
        21 => date('2021-10-20 21:01'),
        22 => date('2021-10-20 22:01'),
        23 => date('2021-10-20 23:01'),
    ];

    $eventos = Evento::whereNotNull('valorNumero')->limit(240)->get();

    foreach ($horarios as $key => $horario) {
        $count = $key * 10;
        for ($i = $count; $i < $count + 10; $i++) {
            $eventos[$i]['dataHora'] = $horario;
            $eventos[$i]['cidade'] = 'São paulo';
            $eventos[$i]['estado'] = 'São paulo';

            $eventos[$i]->save();
        }
    }

    return $eventos;
});
$router->get('/simular-series-textuais', function () {

    $horarios = [
        0 => date('2021-10-20 00:01'),
        1 => date('2021-10-20 01:01'),
        2 => date('2021-10-20 02:01'),
        3 => date('2021-10-20 03:01'),
        4 => date('2021-10-20 04:01'),
        5 => date('2021-10-20 05:01'),
        6 => date('2021-10-20 06:01'),
        7 => date('2021-10-20 07:01'),
        8 => date('2021-10-20 08:01'),
        9 => date('2021-10-20 09:01'),
        10 => date('2021-10-20 10:01'),
        11 => date('2021-10-20 11:01'),
        12 => date('2021-10-20 12:01'),
        13 => date('2021-10-20 13:01'),
        14 => date('2021-10-20 14:01'),
        15 => date('2021-10-20 15:01'),
        16 => date('2021-10-20 16:01'),
        17 => date('2021-10-20 17:01'),
        18 => date('2021-10-20 18:01'),
        19 => date('2021-10-20 19:01'),
        20 => date('2021-10-20 20:01'),
        21 => date('2021-10-20 21:01'),
        22 => date('2021-10-20 22:01'),
        23 => date('2021-10-20 23:01'),
    ];

    $eventos = Evento::whereNotNull('valorTexto')->limit(240)->get();

    foreach ($horarios as $key => $horario) {
        $count = $key * 10;
        for ($i = $count; $i < $count + 10; $i++) {
            $eventos[$i]['dataHora'] = $horario;
            $eventos[$i]['cidade'] = 'São paulo';
            $eventos[$i]['estado'] = 'São paulo';
            $eventos[$i]['valorTexto'] = rand(1, 2) === 1 ? 'chuva' : 'valor simulado';

            $eventos[$i]->save();
        }
    }

    return $eventos;
});
