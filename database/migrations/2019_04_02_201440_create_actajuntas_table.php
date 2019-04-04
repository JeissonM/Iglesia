<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActajuntasTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('actajuntas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('documento', 250);
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
        Schema::dropIfExists('actajuntas');
    }

}
