<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLibrosTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('libros', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('titulo', 150);
            $table->string('resumen');
            $table->string('isbn', 50)->nullable();
            $table->string('editorial', 50)->nullable();
            $table->integer('anio')->nullable();
            $table->string('imagen')->default('NO');
            $table->string('documento');
            $table->bigInteger('categorialibro_id')->unsigned();
            $table->foreign('categorialibro_id')->references('id')->on('categorialibros')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('libros');
    }

}
