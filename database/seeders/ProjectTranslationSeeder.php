<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectTranslationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \Illuminate\Support\Facades\DB::table('project_translations')->insert([
            'project_id' => 1,
            'user_id' => 1,
            'slug' => 'projekt-pierwszy',
            'title' => 'Projekt pierwszy',
            'intro' => 'Wstęp do Projekt pierwszego',
            'content' => "Cel Projektu pierwszego",
            'result' => "Rezultat Projektu pierwszego",
            'site_description' => '',
            'site_keyword' => '',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
