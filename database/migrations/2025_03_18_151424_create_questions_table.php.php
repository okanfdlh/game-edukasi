<?php

// Create database table for questions
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateQuestionsTable extends Migration
{
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_soal'); // jenis soal (umum, matematika, tentang kampus)
            $table->string('pertanyaan');
            $table->string('pilihan_jawaban')->nullable(); // pilihan jawaban
            $table->integer('jawaban_benar')->nullable(); // jawaban benar
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('questions');
    }
}

