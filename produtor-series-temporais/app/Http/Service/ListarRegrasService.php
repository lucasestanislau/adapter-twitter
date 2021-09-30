<?php

namespace App\Http\Service;

use App\Models\Regra;

class ListarRegrasService
{

    public function executar()
    {
      return Regra::all();
    }
}
