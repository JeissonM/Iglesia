<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMiembrojuntasTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('miembrojuntas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('feligres_id')->unsigned();
            $table->foreign('feligres_id')->references('id')->on('feligres')->onDelete('cascade');
            $table->bigInteger('cargogeneral_id')->unsigned();
            $table->foreign('cargogeneral_id')->references('id')->on('cargogenerals')->onDelete('cascade');
            $table->bigInteger('junta_id')->unsigned();
            $table->foreign('junta_id')->references('id')->on('juntas')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('miembrojuntas');
    }

}
