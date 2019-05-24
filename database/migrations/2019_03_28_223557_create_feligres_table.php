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
            $table->string('retiro_por')->nullable();
            $table->string('pastor_oficiante')->nullable();
            $table->string('estado_actual');
            $table->date('fecha_bautismo');
            $table->string('asociacion_origen')->nullable();
            $table->string('distrito_origen')->nullable();
            $table->string('iglesia_origen')->nullable();
            $table->string('asociacion_destino');
            $table->string('distrito_destino');
            $table->string('iglesia_destino');
            $table->bigInteger('iglesia_id')->unsigned()->nullable(); //iglesia actual
            $table->foreign('iglesia_id')->references('id')->on('iglesias')->onDelete('cascade');
            $table->bigInteger('personanatural_id')->unsigned();
            $table->foreign('personanatural_id')->references('id')->on('personanaturals')->onDelete('cascade');
            $table->bigInteger('situacionfeligres_id')->unsigned();
            $table->foreign('situacionfeligres_id')->references('id')->on('situacionfeligres')->onDelete('cascade');

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
