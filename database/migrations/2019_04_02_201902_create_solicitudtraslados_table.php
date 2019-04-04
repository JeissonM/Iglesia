<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSolicitudtrasladosTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('solicitudtraslados', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tiposolicitud', 20);
            $table->date('fechasolicitud');
            $table->string('observacion_origen')->nullable();
            $table->string('observacion_destino')->nullable();
            $table->string('estado', 30)->default('PENDIENTE');
            $table->string('iglesia_origen')->nullable();
            $table->string('iglesia_destino')->nullable();
            $table->bigInteger('acta_origen')->nullable();
            $table->bigInteger('acta_destino')->nullable();
            $table->bigInteger('feligres_id')->unsigned();
            $table->foreign('feligres_id')->references('id')->on('feligres')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('solicitudtraslados');
    }

}
