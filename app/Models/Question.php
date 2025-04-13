<?php

// Question Model
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['jenis_soal', 'pertanyaan', 'pilihan_jawaban', 'jawaban_benar'];
}

