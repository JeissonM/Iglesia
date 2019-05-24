<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoricosituacionsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('historicosituacions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('situacionfeligres_id')->unsigned();
            $table->foreign('situacionfeligres_id')->references('id')->on('situacionfeligres')->onDelete('cascade');
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
        Schema::dropIfExists('historicosituacions');
    }

}
