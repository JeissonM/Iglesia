<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJuntasTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('juntas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('etiqueta');
            $table->string('vigente', 5);
            $table->bigInteger('iglesia_id')->unsigned(); //iglesia junta
            $table->foreign('iglesia_id')->references('id')->on('iglesias')->onDelete('cascade');
            $table->bigInteger('pastor_id')->unsigned();
            $table->foreign('pastor_id')->references('id')->on('pastors')->onDelete('cascade');
            $table->bigInteger('periodo_id')->unsigned();
            $table->foreign('periodo_id')->references('id')->on('periodos')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('juntas');
    }

}
