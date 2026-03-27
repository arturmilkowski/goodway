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
            'title' => 'Strona główna',
            'intro' => 'Fundacja Good Way',
            'content' => "Fundacja Good Way",
            'site_description' => '',
            'site_keyword' => '',
            'navbar' => true,
            'hide' => false,
            'ordinal' => 10,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        \Illuminate\Support\Facades\DB::table('pages')->insert([
            'user_id' => 1,
            'slug' => 'o-fundacji',
            'title' => 'O fundacji',
            'intro' => 'O fundacji Good Way',
            'content' => "Fundacja Good Way",
            'site_description' => '',
            'site_keyword' => '',
            'navbar' => true,
            'hide' => false,
            'ordinal' => 20,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        \Illuminate\Support\Facades\DB::table('pages')->insert([
            'user_id' => 1,
            'slug' => 'misja',
            'title' => 'Misja',
            'intro' => 'Nasza misja',
            'content' => "Naszą misją jest pomaganie ludziom",
            'site_description' => '',
            'site_keyword' => '',
            'navbar' => true,
            'hide' => false,
            'ordinal' => 30,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        \Illuminate\Support\Facades\DB::table('pages')->insert([
            'user_id' => 1,
            'slug' => 'badania',
            'title' => 'Badania',
            'intro' => 'Prace i badania naukowe',
            'content' => "Reaserch",
            'site_description' => '',
            'site_keyword' => '',
            'navbar' => true,
            'hide' => false,
            'ordinal' => 40,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        \Illuminate\Support\Facades\DB::table('pages')->insert([
            'user_id' => 1,
            'slug' => 'wspolpraca',
            'title' => 'Współpraca',
            'intro' => '',
            'content' => "",
            'site_description' => '',
            'site_keyword' => '',
            'navbar' => true,
            'hide' => false,
            'ordinal' => 50,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        \Illuminate\Support\Facades\DB::table('pages')->insert([
            'user_id' => 1,
            'slug' => 'dotacje',
            'title' => 'Dotacje',
            'intro' => '',
            'content' => "",
            'site_description' => '',
            'site_keyword' => '',
            'navbar' => true,
            'hide' => false,
            'ordinal' => 60,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        \Illuminate\Support\Facades\DB::table('pages')->insert([
            'user_id' => 1,
            'slug' => 'kontakt',
            'title' => 'Kontakt',
            'intro' => 'Napisz do nas',
            'content' => "Formularz kontaktowy",
            'site_description' => '',
            'site_keyword' => '',
            'navbar' => true,
            'hide' => false,
            'ordinal' => 70,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        // polityka-prywatnosci
        //  /regulamin
        // /rodo
    }
}
