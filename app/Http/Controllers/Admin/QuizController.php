<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index()
    {
        $items = Quiz::withCount('questions')->latest()->get();
        return view('admin.quiz.index', compact('items'));
    }

    public function create()
    {
        return view('admin.quiz.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'                => 'required|string|max:255',
            'questions'            => 'required|array|min:1',
            'questions.*.question' => 'required|string',
            'questions.*.option_a' => 'required|string',
            'questions.*.option_b' => 'required|string',
            'questions.*.option_c' => 'required|string',
            'questions.*.option_d' => 'required|string',
            'questions.*.option_e' => 'required|string',
            'questions.*.correct_answer' => 'required|in:A,B,C,D,E',
        ]);

        // Simpan quiz
        $quiz = Quiz::create([
            'title' => $request->title
        ]);

        // Simpan pertanyaan
        foreach ($request->questions as $q) {
            $quiz->questions()->create($q);
        }

        return redirect()->route('admin.quiz.index')->with('success', 'Quiz created successfully.');
    }

    public function edit($id)
    {
        $quiz = Quiz::with('questions')->findOrFail($id);
        return view('admin.quiz.edit', compact('quiz'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title'                => 'required|string|max:255',
            'questions'            => 'required|array|min:1',
            'questions.*.id'       => 'nullable|exists:quiz_questions,id',
            'questions.*.question' => 'required|string',
            'questions.*.option_a' => 'required|string',
            'questions.*.option_b' => 'required|string',
            'questions.*.option_c' => 'required|string',
            'questions.*.option_d' => 'required|string',
            'questions.*.option_e' => 'required|string',
            'questions.*.correct_answer' => 'required|in:A,B,C,D,E',
        ]);

        $quiz = Quiz::findOrFail($id);
        $quiz->update(['title' => $request->title]);

        // Hapus semua pertanyaan lama dan simpan ulang (opsi paling simpel)
        $quiz->questions()->delete();
        foreach ($request->questions as $q) {
            $quiz->questions()->create($q);
        }

        return redirect()->route('admin.quiz.index')->with('success', 'Quiz updated successfully.');
    }

    public function destroy($id)
    {
        $quiz = Quiz::findOrFail($id);
        $quiz->questions()->delete();
        $quiz->delete();

        return redirect()->route('admin.quiz.index')->with('success', 'Quiz deleted.');
    }
}
