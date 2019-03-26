<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIglesiasTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('iglesias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre');
            $table->string('descripcion')->nullable();
            $table->string('ubicacion')->nullable();
            $table->string('email')->nullable();
            $table->date('fundacion')->nullable();
            $table->string('activa')->default('1')->nullable();
            $table->string('sitioweb')->nullable();
            $table->string('tipo', 50)->default('IGLESIA');
            $table->bigInteger('ciudad_id')->unsigned();
            $table->foreign('ciudad_id')->references('id')->on('ciudads')->onDelete('cascade');
            $table->bigInteger('distrito_id')->unsigned();
            $table->foreign('distrito_id')->references('id')->on('distritos')->onDelete('cascade');
            $table->bigInteger('zona_id')->unsigned()->nullable();
            $table->foreign('zona_id')->references('id')->on('zonas')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('iglesias');
    }

}
