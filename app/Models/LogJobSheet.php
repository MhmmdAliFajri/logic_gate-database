<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogJobsheet extends Model
{
    use HasFactory;
    protected $table = 'log_jobsheets';
    protected $fillable = ['user_id', 'jobsheet_id', 'link_pdf', 'nilai', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jobsheet()
    {
        return $this->belongsTo(Jobsheet::class);
    }
}