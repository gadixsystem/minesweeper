<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMinesweeperModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('minesweeper_models', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText("grid");
            $table->longText("userGrid");
            $table->integer("rows");
            $table->integer("columns");
            $table->integer("mines");
            $table->boolean("gameover")->default(false);
            $table->integer("user_id")->nullable();
            $table->integer("time")->nullable();
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
        Schema::dropIfExists('minesweeper_models');
    }
}
