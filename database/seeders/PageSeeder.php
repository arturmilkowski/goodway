<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \Illuminate\Support\Facades\DB::table('pages')->insert([
            'user_id' => 1,
            'slug' => '',
            'name' => 'Start',
            'intro' => 'Fundacja Good Way',
            'content' => "Fundacja Good Way",
            'site_description' => '',
            'site_keyword' => '',
            'navbar' => true,
            'hide' => false,
            'ordinal' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        \Illuminate\Support\Facades\DB::table('pages')->insert([
            'user_id' => 1,
            'slug' => 'misja',
            'name' => 'Misja',
            'intro' => 'Nasza misja',
            'content' => "Naszą misją jest pomaganie ludziom",
            'site_description' => '',
            'site_keyword' => '',
            'navbar' => true,
            'hide' => false,
            'ordinal' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        \Illuminate\Support\Facades\DB::table('pages')->insert([
            'user_id' => 1,
            'slug' => 'kontakt',
            'name' => 'Kontakt',
            'intro' => 'Napisz do nas',
            'content' => "Formularz kontaktowy",
            'site_description' => '',
            'site_keyword' => '',
            'navbar' => true,
            'hide' => false,
            'ordinal' => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
