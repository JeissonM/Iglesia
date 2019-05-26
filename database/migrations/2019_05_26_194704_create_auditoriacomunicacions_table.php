<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuditoriacomunicacionsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('auditoriacomunicacions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('usuario');
            $table->string('operacion');
            $table->text('detalles');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('auditoriacomunicacions');
    }

}
