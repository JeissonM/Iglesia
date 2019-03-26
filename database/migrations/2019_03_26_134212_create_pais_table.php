<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaisTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('pais', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('codigo', 3)->unique();
            $table->string('nombre');
            $table->string('continente')->nullable();
            $table->string('region')->nullable();
            $table->float('area', 10, 2)->nullable();
            $table->integer('independencia')->nullable();
            $table->integer('poblacion')->nullable();
            $table->float('expectativa_vida', 10, 2)->nullable();
            $table->float('producto_interno_bruto', 10, 2)->nullable();
            $table->float('producto_interno_bruto_antiguo', 10, 2)->nullable();
            $table->string('nombre_local', 50)->nullable();
            $table->string('gobierno', 50)->nullable();
            $table->string('jefe_estado', 70)->nullable();
            $table->integer('capital')->nullable();
            $table->string('codigo_dos', 5)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('pais');
    }

}
