<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListapredicacionsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('listapredicacions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('periodoespecifico', 100);
            $table->bigInteger('distrito_id')->unsigned();
            $table->foreign('distrito_id')->references('id')->on('distritos')->onDelete('cascade');
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
        Schema::dropIfExists('listapredicacions');
    }

}
