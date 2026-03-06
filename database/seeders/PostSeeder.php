<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \Illuminate\Support\Facades\DB::table('posts')->insert([
            'user_id' => 1,
            'slug' => 'wpis-pierwszy',
            'title' => 'Wpis pierwszy',
            'intro' => 'Wstęp  do pierwszego  wpisu',
            'content' => 'Zawartość pierwszego  wpisu',
            'img' => '',
            'img1' => '',
            'site_description' => '',
            'site_keyword' => '',
            'approved' => '1',
            'published' => '1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        \Illuminate\Support\Facades\DB::table('posts')->insert([
            'user_id' => 1,
            'slug' => 'wpis-drugi',
            'title' => 'Wpis drugi',
            'intro' => 'Wstęp  do drugiego wpisu',
            'content' => 'Zawartość drugiego wpisu',
            'img' => '',
            'img1' => '',
            'site_description' => '',
            'site_keyword' => '',
            'approved' => '1',
            'published' => '1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
