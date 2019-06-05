<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSermonsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('sermons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('titulo', 150);
            $table->string('descripcion');
            $table->string('tipoautor', 15);
            $table->string('tipo', 15);
            $table->string('archivo')->nullable();
            $table->string('otro')->nullable();
            $table->bigInteger('feligres_id')->unsigned()->nullable();
            $table->foreign('feligres_id')->references('id')->on('feligres')->onDelete('cascade');
            $table->bigInteger('pastor_id')->unsigned()->nullable();
            $table->foreign('pastor_id')->references('id')->on('pastors')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('sermons');
    }

}
