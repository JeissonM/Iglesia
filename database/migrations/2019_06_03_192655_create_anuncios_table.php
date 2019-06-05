<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnunciosTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('anuncios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tipo', 20)->default('LOCAL'); //LOCAL, DISTRITO, ASOCIACIÓN...
            $table->string('titulo');
            $table->text('contenido');
            $table->string('autor');
            $table->string('imagen')->default('NO');
            $table->string('estado', 50)->default('VIGENTE'); //VIGENTE, VENCIDO
            $table->bigInteger('iglesia_id')->unsigned()->nullable();
            $table->foreign('iglesia_id')->references('id')->on('iglesias')->onDelete('cascade');
            $table->bigInteger('distrito_id')->unsigned()->nullable();
            $table->foreign('distrito_id')->references('id')->on('distritos')->onDelete('cascade');
            $table->bigInteger('asociacion_id')->unsigned()->nullable();
            $table->foreign('asociacion_id')->references('id')->on('asociacions')->onDelete('cascade');
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
        Schema::dropIfExists('anuncios');
    }

}
