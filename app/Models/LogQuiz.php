<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LogQuiz extends Model
{
    use HasFactory;

    protected $table = 'log_quiz';
    protected $fillable = [
        'user_id',
        'quiz_id',
        'question_id',
        'selected_answer',
        'is_correct'
    ];

    // Relasi: Log milik satu user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi: Log milik satu quiz
    public function quiz()
    {
        return $this->belongsTo(Quiz::class, 'quiz_id');
    }

    // Relasi: Log milik satu pertanyaan
    public function question()
    {
        return $this->belongsTo(QuizQuestion::class, 'question_id');
    }
}