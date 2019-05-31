<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMinisterioextrasTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('ministerioextras', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre');
            $table->string('descripcion', 250);
            $table->text('presentacion')->nullable();
            $table->bigInteger('tipoministerio_id')->unsigned();
            $table->foreign('tipoministerio_id')->references('id')->on('tipoministerios')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('ministerioextras');
    }

}
