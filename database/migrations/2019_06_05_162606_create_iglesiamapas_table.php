<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIglesiamapasTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('iglesiamapas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('telefonocontacto')->nullable();
            $table->text('mapa')->nullable();
            $table->bigInteger('iglesia_id')->unsigned();
            $table->foreign('iglesia_id')->references('id')->on('iglesias')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('iglesiamapas');
    }

}
