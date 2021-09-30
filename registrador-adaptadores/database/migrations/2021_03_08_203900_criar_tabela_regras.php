<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CriarTabelaRegras extends Migration
{
    public function up()
    {
        Schema::create('regras', function (Blueprint $table) {
            $table->increments('id');
            $table->string('codigoRegra')->unique();
            $table->string('nomeFonte');
            $table->string('nomeAdaptador');
            $table->string('campoReferenciaTexto')->nullable();
            $table->string('campoReferenciaNumero')->nullable();
            $table->string('campoReferenciaDataHora');
            $table->string('campoLocalizacao1');
            $table->string('campoLocalizacao2')->nullable();
            $table->string('campoLocalizacao3')->nullable();
            $table->string('campoCodigo')->nullable();
            $table->string('descricao');
            $table->json("atributos");
            $table->string("token");
            $table->timestamps();
        });

        Schema::create('eventos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('regra_id');
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('cidade')->nullable();
            $table->string('estado')->nullable();
            $table->dateTime('dataHora');
            $table->string('valorNumero')->nullable();
            $table->string('valorTexto')->nullable();
            $table->string('codigo')->nullable();
            $table->json('json')->nullable();
            $table->timestamps();
        });

        Schema::table('eventos', static function (Blueprint $table) {
            $table->foreign('regra_id')->references('id')->on('regras');
        });
    }

    public function down()
    {
        Schema::drop('eventos');
        Schema::drop('regras');
    }
}
