<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Jobsheet;

class JobsheetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Jobsheet::create([
            'title' => 'Basic CRUD',
            'description' => 'Create a basic CRUD app with Laravel',
            'duration' => 90,
        ]);
    }
}