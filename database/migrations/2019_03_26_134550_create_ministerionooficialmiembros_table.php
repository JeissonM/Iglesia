<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMinisterionooficialmiembrosTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('ministerionooficialmiembros', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('funcion');
            $table->bigInteger('feligres_id')->unsigned();
            $table->foreign('feligres_id')->references('id')->on('feligres')->onDelete('cascade');
            $table->bigInteger('ministerioextra_id')->unsigned();
            $table->foreign('ministerioextra_id')->references('id')->on('ministerioextras')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('ministerionooficialmiembros');
    }

}
