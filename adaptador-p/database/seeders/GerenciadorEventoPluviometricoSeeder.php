<?php

namespace Database\Seeders;

use App\Http\Controllers\BuscaApiCemaden;
use App\Http\Controllers\EnviaEventosPluviometrico;
use App\Models\EventoPluviometrico;
use Illuminate\Database\Seeder;

class GerenciadorEventoPluviometricoSeeder extends Seeder
{
    const token = "c2c44284ee457a116ea7c8b067f99a3a";
    public $numeroRequisicoes = 10;
    public $intervaloSegundosEntreRequisicoes = 600;

    public function run()
    {
        $count = 0;
        while ($count < $this->numeroRequisicoes) {

            $dadosApi = BuscaApiCemaden::executar();

            foreach ($dadosApi->cemaden as $evento) {
                $eventoPluviometrico = new EventoPluviometrico();
                $eventoPluviometrico->codigo_regra = 'cemaden-pluviometrica';
                $eventoPluviometrico->nome = $evento->nome;
                $eventoPluviometrico->uf = $evento->uf;
                $eventoPluviometrico->codestacao = $evento->codestacao;
                $eventoPluviometrico->latitude = $evento->latitude;
                $eventoPluviometrico->longitude =  $evento->longitude;
                $eventoPluviometrico->cidade = $evento->cidade;
                $eventoPluviometrico->dataHora = $evento->dataHora;
                $eventoPluviometrico->chuva = $evento->chuva;
                $eventoPluviometrico->tipo = $evento->tipo;
                EnviaEventosPluviometrico::enviarParaIntegradorFontes(array_merge($eventoPluviometrico->camposFormatados(), ['token' => self::token]));
            }
            $count++;
            sleep($this->intervaloSegundosEntreRequisicoes);
        }
    }
}
