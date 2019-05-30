<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecursosministerialitemsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('recursosministerialitems', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('recurso');
            $table->bigInteger('recursosministerial_id')->unsigned();
            $table->foreign('recursosministerial_id')->references('id')->on('recursosministerials')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('recursosministerialitems');
    }

}
