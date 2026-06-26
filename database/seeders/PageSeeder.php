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
            'navbar' => true,
            'hide' => false,
            'ordinal' => 10,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        \Illuminate\Support\Facades\DB::table('pages')->insert([
            'user_id' => 1,
            'navbar' => true,
            'hide' => false,
            'ordinal' => 20,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        \Illuminate\Support\Facades\DB::table('pages')->insert([
            'user_id' => 1,
            'navbar' => true,
            'hide' => false,
            'ordinal' => 30,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        \Illuminate\Support\Facades\DB::table('pages')->insert([
            'user_id' => 1,
            'navbar' => true,
            'hide' => false,
            'ordinal' => 40,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        \Illuminate\Support\Facades\DB::table('pages')->insert([
            'user_id' => 1,
            'navbar' => true,
            'hide' => false,
            'ordinal' => 50,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        \Illuminate\Support\Facades\DB::table('pages')->insert([
            'user_id' => 1,
            'navbar' => true,
            'hide' => false,
            'ordinal' => 60,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        \Illuminate\Support\Facades\DB::table('pages')->insert([
            'user_id' => 1,
            'navbar' => true,
            'hide' => false,
            'ordinal' => 70,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
