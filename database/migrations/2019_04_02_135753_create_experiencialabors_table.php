<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExperiencialaborsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('experiencialabors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('fechainicio')->nullable();
            $table->date('fechafin')->nullable();
            $table->bigInteger('labor_id')->unsigned();
            $table->foreign('labor_id')->references('id')->on('labors')->onDelete('cascade');
            $table->bigInteger('feligres_id')->unsigned();
            $table->foreign('feligres_id')->references('id')->on('feligres')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('experiencialabors');
    }

}
