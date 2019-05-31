<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePedidosoracionsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('pedidosoracions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('persona')->nullable();
            $table->text('pedido');
            $table->string('correo')->nullable();
            $table->string('tipo', 15);
            $table->string('estado', 20)->default('CREADO');
            $table->bigInteger('feligres_id')->unsigned()->nullable();
            $table->foreign('feligres_id')->references('id')->on('feligres')->onDelete('cascade');
            $table->bigInteger('ciudad_id')->unsigned()->nullable();
            $table->foreign('ciudad_id')->references('id')->on('ciudads')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('pedidosoracions');
    }

}
