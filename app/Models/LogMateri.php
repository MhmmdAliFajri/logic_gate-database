<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogMateri extends Model
{
    use HasFactory;
    protected $table = 'log_materis';

    protected $fillable = ['user_id', 'materi_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}