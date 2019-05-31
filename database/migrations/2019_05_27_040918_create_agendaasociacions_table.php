<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgendaasociacionsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('agendaasociacions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('documento');
            $table->string('estado', 10);
            $table->bigInteger('asociacion_id')->unsigned();
            $table->foreign('asociacion_id')->references('id')->on('asociacions')->onDelete('cascade');
            $table->bigInteger('periodo_id')->unsigned();
            $table->foreign('periodo_id')->references('id')->on('periodos')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('agendaasociacions');
    }

}
