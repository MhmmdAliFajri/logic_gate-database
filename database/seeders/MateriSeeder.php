<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Materi;

class MateriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Materi::create([
            'title' => 'Introduction to Programming',
            'duration' => 60,
            'konten' => 'Basic concepts of programming...',
            'link_pdf' => 'intro_programming.pdf',
        ]);
    }
}
