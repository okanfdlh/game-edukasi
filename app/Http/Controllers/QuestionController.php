<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Score;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = Question::all();
        return view('index', compact('questions'));
    }

    public function store(Request $request)
    {
        // simpan jawaban user
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $questions = Question::whereIn('id', array_keys($request->input('jawaban')))->get()->keyBy('id');

        $nilai = 0;
        foreach ($request->input('jawaban') as $key => $value) {
            if (isset($questions[$key]) && $value == $questions[$key]->jawaban_benar) {
                $nilai++;
            }
        }

        Score::updateOrCreate(
            ['nama' => $user->name],
            ['nilai' => $nilai]
        );

        return redirect()->route('ranking');
    }

    public function ranking()
    {
        $scores = Score::all()->sortByDesc('nilai');
        return view('question.ranking', compact('scores'));
    }
    public function byCategory($category)
    {
        $questions = Question::where('jenis_soal', $category)->get();

        return response()->json($questions);
    }
}
