<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCiudadsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('ciudads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('codigo_dane')->nullable();
            $table->string('nombre');
            $table->integer('estado_dpto')->default(1);
            $table->string('codigo_pais', 5)->nullable();
            $table->string('distrito')->nullable();
            $table->bigInteger('poblacion')->nullable();
            $table->bigInteger('estado_id')->unsigned();
            $table->foreign('estado_id')->references('id')->on('estados')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('ciudads');
    }

}
