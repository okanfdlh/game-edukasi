<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuestionController;
use Illuminate\Http\Request;
use App\Models\QuizVisitor;
use App\Http\Controllers\AdminController;
use App\Models\Question;

Route::get('/welcome', function () {
    return view('welcome');
});

// Route untuk menampilkan pertanyaan
Route::get('/', [QuestionController::class, 'index'])->name('index');

// Route untuk mengirim jawaban
Route::post('/question/submit', [QuestionController::class, 'store'])->name('question.submit');

// Route untuk menampilkan ranking
Route::get('/ranking', [QuestionController::class, 'ranking'])->name('ranking');

Route::post('/submit-npm', function (Request $request) {
    $npm = $request->npm;
    $today = now()->toDateString();

    // Simpan entri baru tanpa memeriksa apakah NPM sudah ada
    QuizVisitor::create([
        'npm' => $npm,
        'visit_date' => $today,
    ]);

    // Hitung jumlah visitor hari ini (termasuk pengunjung yang sama)
    $visitorCount = QuizVisitor::where('visit_date', $today)->count();

    // Simpan ke session
    session([
        'npm' => $npm,
        'visitor_number' => $visitorCount,
        'visited_today' => true
    ]);

    return response()->json([
        'message' => 'Berhasil',
        'visitor_number' => $visitorCount
    ]);
});
Route::get('/quiz-questions', [QuestionController::class, 'getQuestionsByCategory']);

//admin
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/questions', [AdminController::class, 'index'])->name('index');
    Route::get('/visitors', [AdminController::class, 'visitorsToday'])->name('visitors');
    Route::post('/questions', [AdminController::class, 'createQuestion'])->name('createQuestion');
    Route::get('/questions/{question}/edit', [AdminController::class, 'editQuestion'])->name('editQuestion');
    Route::put('/questions/{question}', [AdminController::class, 'updateQuestion'])->name('updateQuestion');
    Route::delete('/questions/{question}', [AdminController::class, 'destroyQuestion'])->name('destroyQuestion');
});
Route::get('/admin/visitors/filter', [AdminController::class, 'visitorfilter'])->name('admin.visitors.filter');

//api
Route::get('/questions/{category}', function ($category) {
    $questions = Question::where('jenis_soal', $category)->get();
    return response()->json($questions);
});
