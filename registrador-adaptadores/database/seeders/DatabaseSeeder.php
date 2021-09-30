<?php

namespace Database\Seeders;

use App\Models\Evento;
use App\Models\Localizacao;
use Exception;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call('UsersTableSeeder');

        // $this->setLocalizacoes();

        $this->setLocalizacoesEventos();
    }

    public function setLocalizacoesEventos()
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
                    $evento->cidade = 'São Paulo';
                    $evento->estado = 'São Paulo';
                    $evento->save();
                }
            }
        } while ($count > 0);
    }

    public function setLocalizacoes()
    {
        $response = file_get_contents('https://servicodados.ibge.gov.br/api/v1/localidades/municipios');

        foreach (json_decode($response) as $res) {
            Localizacao::create([
                'estado' => $res->microrregiao->mesorregiao->UF->sigla,
                'cidade' => $res->nome,
            ]);
        }
    }
}
