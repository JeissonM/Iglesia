<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMultimediaministerialsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('multimediaministerials', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre', 100);
            $table->string('descripcion', 250)->nullable();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('multimediaministerials');
    }

}
