<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostTranslationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \Illuminate\Support\Facades\DB::table('post_translations')->insert([
            'post_id' => 1,
            'user_id' => 1,
            'locale' => 'pl',
            'slug' => 'pierwszy-wpis',
            'title' => 'Pierwszy wpis',
            'intro' => 'Wstęp',
            'content' => "Zawartość",
            'site_description' => '',
            'site_keyword' => '',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
