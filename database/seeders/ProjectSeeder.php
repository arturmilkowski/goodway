<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \Illuminate\Support\Facades\DB::table('projects')->insert([
            'user_id' => 1,
            'slug' => 'projekt-pierwszy',
            'title' => 'Projekt pierwszy',
            'intro' => 'Wstęp do Projekt pierwszego',
            'content' => "Cel Projektu pierwszego",
            'result' => "Rezultat Projektu pierwszego",
            'site_description' => '',
            'site_keyword' => '',
            'approved' => '1',
            'hide' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
