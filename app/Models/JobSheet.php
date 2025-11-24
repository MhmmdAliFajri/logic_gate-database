<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jobsheet extends Model
{
    use HasFactory;
    protected $table = 'jobsheets';
    protected $fillable = ['title', 'description', 'duration', 'link_pdf'];
}