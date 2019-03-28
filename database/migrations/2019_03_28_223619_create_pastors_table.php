<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePastorsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('pastors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('pastor_desde');
            $table->string('jubilado', 5)->default('NO');
            $table->date('fecha_jubilacion')->nullable();
            $table->string('situacion');
            $table->string('pastor_sobre');
            $table->bigInteger('distrito_id')->unsigned(); //distrito actual
            $table->foreign('distrito_id')->references('id')->on('distritos')->onDelete('cascade');
            $table->bigInteger('iglesia_id')->unsigned()->nullable(); //iglesia actual donde tiene la feligresia
            $table->foreign('iglesia_id')->references('id')->on('iglesias')->onDelete('cascade');
            $table->bigInteger('personanatural_id')->unsigned()->nullable();
            $table->foreign('personanatural_id')->references('id')->on('personanaturals')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('pastors');
    }

}
