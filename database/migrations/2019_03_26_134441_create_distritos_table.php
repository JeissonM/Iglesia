<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDistritosTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('distritos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre');
            $table->string('descripcion')->nullable();
            $table->string('ubicacion')->nullable();
            $table->string('email')->nullable();
            $table->string('sitioweb')->nullable();
            $table->bigInteger('ciudad_id')->unsigned();
            $table->foreign('ciudad_id')->references('id')->on('ciudads')->onDelete('cascade');
            $table->bigInteger('zona_id')->unsigned()->nullable();
            $table->foreign('zona_id')->references('id')->on('zonas')->onDelete('cascade');
            $table->bigInteger('asociacion_id')->unsigned();
            $table->foreign('asociacion_id')->references('id')->on('asociacions')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('distritos');
    }

}
