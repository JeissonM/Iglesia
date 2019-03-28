<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeligresTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('feligres', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('aceptado_por')->nullable();
            $table->string('retiro_por')->nulablle();
            $table->string('pastor_oficiante')->nullable();
            $table->string('estado_actual');
            $table->date('fecha_bautismo');
            $table->string('asociacion_origen');
            $table->string('distrito_origen');
            $table->string('iglesia_origen');
            $table->string('asociacion_destino');
            $table->string('distrito_destino');
            $table->string('iglesia_destino');
            $table->bigInteger('iglesia_id')->unsigned()->nullable(); //iglesia actual
            $table->foreign('iglesia_id')->references('id')->on('iglesias')->onDelete('cascade');
            $table->bigInteger('personanatural_id')->unsigned()->nullable();
            $table->foreign('personanatural_id')->references('id')->on('personanaturals')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('feligres');
    }

}
