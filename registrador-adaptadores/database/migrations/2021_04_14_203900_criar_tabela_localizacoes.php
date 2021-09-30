

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CriarTabelaLocalizacoes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('localizacoes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cidade');
            $table->string('estado');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('localizacoes');
    }
}
