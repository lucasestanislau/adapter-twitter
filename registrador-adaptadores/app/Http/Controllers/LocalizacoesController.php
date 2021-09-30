<?php

namespace App\Http\Controllers;

use App\Http\Validators\RegistrarEventoRequestValidator;
use App\Models\Evento;
use App\Models\Localizacao;
use Illuminate\Http\Request;

class LocalizacoesController
{
    public function executar(Request $request)
    {
       return Localizacao::all();
    }

}
