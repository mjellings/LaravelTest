<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRouletteTurnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roulette_turns', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('roulette_game_id')->references('id')->on('roulette_games');
            $table->unsignedInteger('turn');
            $table->double('balance_before');
            $table->double('bet');
            $table->boolean('win');
            $table->double('balance_after');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roulette_turns');
    }
}
