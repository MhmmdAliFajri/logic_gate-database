<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Add;

class AddSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Add::create([
            'title' => 'Laravel Documentation',
            'link' => 'https://laravel.com/docs',
        ]);
    }
}
