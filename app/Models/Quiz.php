<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quiz extends Model
{
    use HasFactory;

    protected $table = 'quiz'; // nama tabel
    protected $fillable = ['title'];

    // Relasi: Satu quiz punya banyak pertanyaan
    public function questions()
    {
        return $this->hasMany(QuizQuestion::class, 'quiz_id');
    }

    // Relasi: Satu quiz punya banyak log pengerjaan
    public function logs()
    {
        return $this->hasMany(LogQuiz::class, 'quiz_id');
    }
}