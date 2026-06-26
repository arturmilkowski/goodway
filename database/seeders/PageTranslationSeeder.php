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
            'site_description' => 'Fundacja bada i rozwija narzędzia pomagające ludziom podejmować lepsze decyzje w najważniejszych obszarach życia.',
            'site_keyword' => 'fundacja, badania, rozwój, narzędzia, decyzje, życie',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        \Illuminate\Support\Facades\DB::table('page_translations')->insert([
            'page_id' => 2,
            'user_id' => 1,
            'locale' => 'pl',
            'slug' => 'o-fundacji',
            'title' => 'O fundacji',
            'intro' => 'Pomagamy ludziom podejmować lepsze decyzje.',
            'content' => "Żyjemy w świecie, w którym każdego dnia podejmujemy setki decyzji dotyczących relacji, informacji, zaufania, bezpieczeństwa i własnej przyszłości. Jednocześnie nigdy wcześniej nie byliśmy otoczeni tak dużą liczbą bodźców, opinii, technologii i źródeł wpływu.
Fundacja Goodway powstała po to, aby tworzyć narzędzia, badania i projekty społeczne pomagające ludziom podejmować bardziej świadome decyzje.
Łączymy nowoczesne technologie, sztuczną inteligencję, badania społeczne i edukację, aby wspierać rozwój człowieka w najważniejszych obszarach życia.
Realizujemy projekty dotyczące:
• relacji i wartości,
• jakości decyzji,
• bezpieczeństwa cyfrowego,
• odporności na manipulację,
• rozwoju osobistego,
• badań społecznych.
Naszą misją jest tworzenie rozwiązań, które pomagają ludziom lepiej rozumieć siebie, innych oraz otaczający ich świat.
Wierzymy, że lepsze decyzje prowadzą do lepszego życia, silniejszych relacji i bardziej odpowiedzialnego społeczeństwa.
Obecnie rozwijamy dwa strategiczne projekty: Lovli oraz Kompas.",
            'site_description' => 'Pomagamy ludziom podejmować lepsze decyzje.',
            'site_keyword' => 'fundacja, badania, rozwój, narzędzia, decyzje, życie',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        \Illuminate\Support\Facades\DB::table('page_translations')->insert([
            'page_id' => 3,
            'user_id' => 1,
            'locale' => 'pl',
            'slug' => 'projekty',
            'title' => 'Projekty',
            'intro' => 'Projekty Fundacji Good Way',
            'content' => "Projekty Fundacji Good Way",
            'site_description' => '',
            'site_keyword' => '',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        \Illuminate\Support\Facades\DB::table('page_translations')->insert([
            'page_id' => 4,
            'user_id' => 1,
            'locale' => 'pl',
            'slug' => 'badania',
            'title' => 'Badania',
            'intro' => 'Badania Fundacji Good Way',
            'content' => "Badania Fundacji Good Way",
            'site_description' => '',
            'site_keyword' => '',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        \Illuminate\Support\Facades\DB::table('page_translations')->insert([
            'page_id' => 5,
            'user_id' => 1,
            'locale' => 'pl',
            'slug' => 'raporty',
            'title' => 'Raporty',
            'intro' => 'Raporty Fundacji Good Way',
            'content' => "Raporty Fundacji Good Way",
            'site_description' => '',
            'site_keyword' => '',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        \Illuminate\Support\Facades\DB::table('page_translations')->insert([
            'page_id' => 6,
            'user_id' => 1,
            'locale' => 'pl',
            'slug' => 'partnerzy',
            'title' => 'Partnerzy',
            'intro' => 'Partnerzy Fundacji Good Way',
            'content' => "Partnerzy Fundacji Good Way",
            'site_description' => '',
            'site_keyword' => '',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        \Illuminate\Support\Facades\DB::table('page_translations')->insert([
            'page_id' => 7,
            'user_id' => 1,
            'locale' => 'pl',
            'slug' => 'kontakt',
            'title' => 'Kontakt',
            'intro' => 'Kontakt z Fundacją Good Way',
            'content' => "Kontakt z Fundacją Good Way",
            'site_description' => '',
            'site_keyword' => '',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
