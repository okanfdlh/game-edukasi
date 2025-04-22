<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\QuizVisitor;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Menampilkan soal kuis
    public function index()
    {
        $questions = Question::all();
        return view('admin.index', compact('questions'));
    }

    // Menampilkan pengunjung hari ini
    public function visitorsToday()
    {
        $today = now()->toDateString();
        $visitors = QuizVisitor::where('visit_date', $today)->get();
        return view('admin.visitors', compact('visitors'));
    }

    // Menambahkan soal kuis baru
    public function createQuestion(Request $request)
    {
        $request->validate([
            'jenis_soal' => 'required|string|max:50',
            'pertanyaan' => 'required|string|max:255',
            'pilihan' => 'required|array|min:2',
            'jawaban_benar' => 'required|integer|min:0|max:' . (count($request->input('pilihan')) - 1),
        ]);

        Question::create([
            'jenis_soal' => $request->jenis_soal,
            'pertanyaan' => $request->pertanyaan,
            'pilihan_jawaban' => json_encode($request->pilihan),
            'jawaban_benar' => $request->jawaban_benar,
        ]);

        return redirect()->route('admin.index')->with('success', 'Soal kuis berhasil ditambahkan!');
    }

    // Menampilkan form edit
    public function editQuestion(Question $question)
    {
        $question->pilihan = json_decode($question->pilihan_jawaban, true);
        return view('admin.edit', compact('question'));
    }

    // Update soal kuis
    public function updateQuestion(Request $request, Question $question)
{
    // Validasi input
    $request->validate([
        'jenis_soal' => 'required|string|max:50',
        'pertanyaan' => 'required|string|max:255',
        'pilihan' => 'required|array|min:2',
        'jawaban_benar' => 'required|integer|min:0|max:' . (count($request->input('pilihan', [])) - 1), // Gunakan default array kosong untuk menghindari null
    ]);

    // Update soal
    $question->update([
        'jenis_soal' => $request->jenis_soal,
        'pertanyaan' => $request->pertanyaan,
        'pilihan_jawaban' => json_encode($request->pilihan),
        'jawaban_benar' => $request->jawaban_benar,
    ]);

    return redirect()->route('admin.index')->with('success', 'Soal kuis berhasil diperbarui!');
}


    // Menghapus soal kuis
    public function destroyQuestion(Question $question)
    {
        $question->delete();
        return redirect()->route('admin.index')->with('success', 'Soal kuis berhasil dihapus!');
    }

//filter hari
public function visitorfilter(Request $request)
{
    $query = QuizVisitor::query();

    if ($request->filled('tanggal')) {
        $query->whereDate('visit_date', $request->tanggal);
    }

    $visitors = $query->get();

    return view('admin.visitors', compact('visitors'));
}

}