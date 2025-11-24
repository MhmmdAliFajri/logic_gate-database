<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LogQuiz;
use App\Models\LogJobsheet;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LeaderboardApiController extends Controller
{
    //
    public function index()
    {
        // Hitung skor dari LogQuiz (per kuis)
        $quizScores = LogQuiz::select(
            'user_id',
            DB::raw('SUM((benar_per_quiz / total_per_quiz) * 100) as skor_quiz')
        )
        ->fromSub(function ($query) {
            $query->select(
                'user_id',
                'quiz_id',
                DB::raw('SUM(CASE WHEN is_correct = 1 THEN 1 ELSE 0 END) as benar_per_quiz'),
                DB::raw('COUNT(*) as total_per_quiz')
            )
            ->from('log_quiz')
            ->groupBy('user_id', 'quiz_id');
        }, 'quiz_summary')
        ->groupBy('user_id');

        $jobsheetScores = LogJobsheet::select(
            'user_id',
            DB::raw('SUM(nilai) as skor_jobsheet')
        )
        ->groupBy('user_id');

        $leaderboard = User::select(
            'users.id',
            'users.name',
            DB::raw('ROUND(COALESCE(q.skor_quiz, 0) + COALESCE(j.skor_jobsheet, 0)) as total_skor'),
            DB::raw('ROUND(COALESCE(q.skor_quiz, 0)) as skor_quiz'),
            DB::raw('ROUND(COALESCE(j.skor_jobsheet, 0)) as skor_jobsheet')
        )
        ->leftJoinSub($quizScores, 'q', function($join) {
            $join->on('users.id', '=', 'q.user_id');
        })
        ->leftJoinSub($jobsheetScores, 'j', function($join) {
            $join->on('users.id', '=', 'j.user_id');
        })
        ->where('role', '!=', 'admin') // hanya user biasa
        ->orderByDesc('total_skor')
        ->get();

        return response()->json([
            'status' => true,
            'data' => $leaderboard
        ]);
    }

    public function myRank()
    {
        $userId = auth()->id();

        // Hitung skor quiz (per kuis)
        $quizScores = LogQuiz::select(
                'user_id',
                DB::raw('SUM((benar_per_quiz / total_per_quiz) * 100) as skor_quiz')
            )
            ->fromSub(function ($query) {
                $query->select(
                        'user_id',
                        'quiz_id',
                        DB::raw('SUM(CASE WHEN is_correct = 1 THEN 1 ELSE 0 END) as benar_per_quiz'),
                        DB::raw('COUNT(*) as total_per_quiz')
                    )
                    ->from('log_quiz')
                    ->groupBy('user_id', 'quiz_id');
            }, 'quiz_summary')
            ->groupBy('user_id');

        // Hitung skor jobsheet
        $jobsheetScores = LogJobsheet::select(
                'user_id',
                DB::raw('SUM(nilai) as skor_jobsheet')
            )
            ->groupBy('user_id');

        // Gabungkan leaderboard
        $leaderboard = User::select(
                'users.id',
                'users.name',
                DB::raw('COALESCE(q.skor_quiz, 0) + COALESCE(j.skor_jobsheet, 0) as total_skor'),
                DB::raw('COALESCE(q.skor_quiz, 0) as skor_quiz'),
                DB::raw('COALESCE(j.skor_jobsheet, 0) as skor_jobsheet')
            )
            ->leftJoinSub($quizScores, 'q', function($join) {
                $join->on('users.id', '=', 'q.user_id');
            })
            ->leftJoinSub($jobsheetScores, 'j', function($join) {
                $join->on('users.id', '=', 'j.user_id');
            })
            ->where('role', '!=', 'admin') // exclude admin
            ->orderByDesc('total_skor')
            ->get();

        // Cari ranking user login
        $rank = $leaderboard->search(function ($user) use ($userId) {
            return $user->id == $userId;
        });

        if ($rank === false) {
            return response()->json([
                'status' => false,
                'message' => 'User tidak ditemukan di leaderboard'
            ], 404);
        }

        $userRank = $leaderboard[$rank];

        // Hitung total user (bukan admin)
        $totalUser = User::where('role', '!=', 'admin')->count();

        return response()->json([
            'status' => true,
            'data' => [
                'rank' => $rank + 1, // index mulai dari 0, jadi +1
                'user' => [
                    'id' => $userRank->id,
                    'name' => $userRank->name,
                    'total_skor' => round($userRank->total_skor), // dibulatkan
                    'skor_quiz' => round($userRank->skor_quiz),
                    'skor_jobsheet' => round($userRank->skor_jobsheet),
                ],
                'total_user' => $totalUser
            ]
        ]);
    }

}