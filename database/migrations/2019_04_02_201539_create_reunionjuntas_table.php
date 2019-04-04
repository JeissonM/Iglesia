<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReunionjuntasTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('reunionjuntas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('titulo');
            $table->date('fecha');
            $table->text('asistentes');
            $table->text('conclusiones');
            $table->bigInteger('junta_id')->unsigned();
            $table->foreign('junta_id')->references('id')->on('juntas')->onDelete('cascade');
            $table->bigInteger('agendajunta_id')->unsigned();
            $table->foreign('agendajunta_id')->references('id')->on('agendajuntas')->onDelete('cascade');
            $table->bigInteger('actajunta_id')->unsigned()->nullable();
            $table->foreign('actajunta_id')->references('id')->on('actajuntas')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('reunionjuntas');
    }

}
