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
            // 'img' => 'images/project/project1.png',
            // 'img1' => 'images/project/project1_.png',
            'approved' => true,
            'hide' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        \Illuminate\Support\Facades\DB::table('projects')->insert([
            'user_id' => 1,
            // 'img' => 'images/project/project1.png',
            // 'img1' => 'images/project/project1_.png',
            'approved' => true,
            'hide' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
