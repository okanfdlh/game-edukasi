<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuestionController; // <-- Tambahkan ini

Route::get('/welcome', function () {
    return view('welcome');
});

// Route untuk menampilkan pertanyaan
Route::get('/', [QuestionController::class, 'index'])->name('index');

// Route untuk mengirim jawaban
Route::post('/question/submit', [QuestionController::class, 'store'])->name('question.submit');

// Route untuk menampilkan ranking
Route::get('/ranking', [QuestionController::class, 'ranking'])->name('ranking');
