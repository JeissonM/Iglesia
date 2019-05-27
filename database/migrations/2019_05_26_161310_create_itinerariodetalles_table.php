<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItinerariodetallesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('itinerariodetalles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('orden');
            $table->string('descripcion');
            $table->string('horainicial', 5);
            $table->string('horafinal', 5);
            $table->bigInteger('itinerario_id')->unsigned();
            $table->foreign('itinerario_id')->references('id')->on('itinerarios')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('itinerariodetalles');
    }

}
