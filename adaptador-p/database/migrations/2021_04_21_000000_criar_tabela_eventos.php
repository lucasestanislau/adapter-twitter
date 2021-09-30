<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CriarTabelaEventos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eventos', function (Blueprint $table) {
            $table->increments("id");
            $table->string('codigo_regra')->default("cemaden-pluviometrica");
            $table->string('codestacao');
            $table->string('latitude');
            $table->string('longitude');
            $table->string('cidade');
            $table->string('dataHora');
            $table->string('chuva')->nullable();
            $table->string('tipo');
           
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('eventos');
    }
}
