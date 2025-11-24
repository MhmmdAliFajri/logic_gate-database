<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\LogQuiz;
use Illuminate\Support\Facades\Auth;

class QuizApiController extends Controller
{
    /**
     * GET /api/quizzes
     * List semua quiz
     */
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $quizzes = Quiz::withCount('questions')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($quiz) use ($user) {
                $log = LogQuiz::where('quiz_id', $quiz->id)
                    ->where('user_id', $user->id)
                    ->first();

                $isAttempted = $log !== null;

                $score = null;
                if ($isAttempted) {
                    $correctAnswers = LogQuiz::where('quiz_id', $quiz->id)
                        ->where('user_id', $user->id)
                        ->where('is_correct', true)
                        ->count();

                    $totalQuestions = $quiz->questions_count ?: 1;
                    $score = round(($correctAnswers / $totalQuestions) * 100, 2);
                }

                return [
                    'id' => $quiz->id,
                    'title' => $quiz->title,
                    'total_questions' => $quiz->questions_count,
                    'attempted' => $isAttempted,
                    'score' => $score, // null jika belum dikerjakan
                ];
            });

        return response()->json([
            'message' => 'Quiz list retrieved successfully.',
            'data' => $quizzes
        ]);
    }

    /**
     * GET /api/quizzes/{id}
     * Ambil detail quiz + pertanyaan
     */
    public function show($id)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $quiz = Quiz::with('questions')->findOrFail($id);

        // Ambil semua log user untuk quiz ini
        $logs = LogQuiz::where('quiz_id', $quiz->id)
            ->where('user_id', $user->id)
            ->get()
            ->keyBy('question_id'); // supaya gampang nyocokin

        $isAttempted = $logs->isNotEmpty();
        $score = null;

        if ($isAttempted) {
            $correctAnswers = $logs->where('is_correct', true)->count();
            $totalQuestions = $quiz->questions->count() ?: 1;
            $score = round(($correctAnswers / $totalQuestions) * 100, 2);
        }

        // Detail pertanyaan + jawaban user
        $questions = $quiz->questions->map(function ($q) use ($logs) {
            $userAnswer = $logs->has($q->id) ? $logs[$q->id]->selected_answer : null;
            $isCorrect = $logs->has($q->id) ? $logs[$q->id]->is_correct : null;

            return [
                'id' => $q->id,
                'question' => $q->question,
                'options' => [
                    'A' => $q->option_a,
                    'B' => $q->option_b,
                    'C' => $q->option_c,
                    'D' => $q->option_d,
                    'E' => $q->option_e,
                ],
                'correct_answer' => $q->correct_answer, // kunci jawaban
                'user_answer' => $userAnswer,           // jawaban user
                'is_correct' => $isCorrect              // true/false/null
            ];
        });

        return response()->json([
            'message' => 'Quiz retrieved successfully.',
            'data' => [
                'id' => $quiz->id,
                'title' => $quiz->title,
                'total_questions' => $quiz->questions->count(),
                'attempted' => $isAttempted,
                'score' => $score,
                'questions' => $questions
            ]
        ]);
    }


    /**
     * POST /api/quizzes/{id}/submit
     * Simpan jawaban user
     */
    public function submit(Request $request, $id)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $request->validate([
            'answers' => 'required|array',
            'answers.*.question_id' => 'required|exists:quiz_questions,id',
            'answers.*.selected_answer' => 'required|string'
        ]);

        $quiz = Quiz::findOrFail($id);

        $score = 0;
        $totalQuestions = count($request->answers);

        foreach ($request->answers as $answer) {
            $question = QuizQuestion::findOrFail($answer['question_id']);
            $isCorrect = strtolower($answer['selected_answer']) === strtolower($question->correct_answer);

            if ($isCorrect) {
                $score++;
            }

            LogQuiz::create([
                'user_id' => $user->id,
                'quiz_id' => $quiz->id,
                'question_id' => $question->id,
                'selected_answer' => $answer['selected_answer'],
                'is_correct' => $isCorrect
            ]);
        }

        // Hitung skor persentase (0 - 100)
        $percentage = ($score / $totalQuestions) * 100;

        return response()->json([
            'message' => 'Quiz submitted successfully.',
            'score' => round($percentage, 2), // hasil persentase
            'total_questions' => $totalQuestions,
            'correct_answers' => $score
        ]);
    }

}
