<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PageTranslationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \Illuminate\Support\Facades\DB::table('page_translations')->insert([
            'page_id' => 1,
            'user_id' => 1,
            'locale' => 'pl',
            'slug' => '',
            'title' => 'Strona główna',
            'intro' => 'Fundacja Good Way',
            'content' => "Fundacja Good Way",
            'site_description' => '',
            'site_keyword' => '',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        \Illuminate\Support\Facades\DB::table('page_translations')->insert([
            'page_id' => 2,
            'user_id' => 1,
            'locale' => 'pl',
            'slug' => 'o-nas',
            'title' => 'O nas',
            'intro' => 'O fundacji Good Way',
            'content' => "O Fundacji Good Way",
            'site_description' => '',
            'site_keyword' => '',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
