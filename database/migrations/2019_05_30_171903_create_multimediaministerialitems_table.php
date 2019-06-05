<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMultimediaministerialitemsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('multimediaministerialitems', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('recurso');
            $table->bigInteger('multimediaministerial_id')->unsigned();
            $table->foreign('multimediaministerial_id')->references('id')->on('multimediaministerials')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('multimediaministerialitems');
    }

}
