<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLppredicadoriglesiasTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('lppredicadoriglesias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('iglesia_id')->unsigned();
            $table->foreign('iglesia_id')->references('id')->on('iglesias')->onDelete('cascade');
            $table->bigInteger('feligres_id')->unsigned()->nullable();
            $table->foreign('feligres_id')->references('id')->on('feligres')->onDelete('cascade');
            $table->bigInteger('listapredicacionfecha_id')->unsigned();
            $table->foreign('listapredicacionfecha_id')->references('id')->on('listapredicacionfechas')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('lppredicadoriglesias');
    }

}
