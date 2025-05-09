<?php

// Create database table for scores
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScoresTable extends Migration
{
    public function up()
    {
        Schema::create('scores', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->integer('nilai');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('scores');
    }
}
