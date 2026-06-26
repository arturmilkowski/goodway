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
            'locale' => 'pl',
            'slug' => 'lovli',
            'title' => 'Lovli',
            'intro' => 'Lovli.io – Odkryj swój model szczęścia. Odkryj siebie. Odkryj drugiego człowieka.',
            'content' => "ODNAJDŹ SWOJE SZCZĘŚCIE. POZNAJ KOGOŚ, KTO NAPRAWDĘ DO CIEBIE PASUJE.
Lovli to innowacyjny projekt społeczno-badawczy rozwijany przez Fundację Goodway, którego celem jest wspieranie młodych ludzi w budowaniu trwałych, świadomych i wartościowych relacji.
Współczesne aplikacje randkowe skupiają się głównie na wyglądzie, pierwszym wrażeniu i szybkich decyzjach. Tymczasem trwałe związki budowane są na znacznie głębszych fundamentach: wartościach, celach życiowych, osobowości, sposobie komunikacji, wizji rodziny oraz rozumieniu szczęścia.
Dlatego Lovli odwraca tradycyjny proces poznawania ludzi.
Najpierw pomaga użytkownikowi lepiej poznać samego siebie.
Poprzez serię interaktywnych pytań, gier, quizów i analiz uczestnik odkrywa własne wartości, potrzeby, cele życiowe oraz indywidualny model szczęścia. Dopiero na tej podstawie system pomaga odnajdywać osoby o wysokim poziomie zgodności.
Proces poznawania odbywa się stopniowo i anonimowo. Uczestnicy odkrywają siebie nawzajem poprzez rozmowy, zadania i wspólne aktywności prowadzone przez system. Zdjęcia, dane osobowe i bezpośredni kontakt pojawiają się dopiero wtedy, gdy obie strony osiągną odpowiedni poziom wzajemnego poznania i zaufania.
Lovli nie jest portalem randkowym.
To narzędzie pomagające budować relacje oparte na wartościach, wzajemnym zrozumieniu i świadomych decyzjach.
Projekt posiada również wymiar badawczy. W sposób anonimowy i zgodny z obowiązującymi przepisami analizuje proces budowania relacji, zgodność wartości oraz czynniki wpływające na trwałość związków. Celem jest tworzenie wiedzy, która może wspierać rozwój zdrowych relacji, rodzin i społeczności.
            ",
            'result' => "",
            'site_description' => '',
            'site_keyword' => '',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        \Illuminate\Support\Facades\DB::table('project_translations')->insert([
            'project_id' => 2,
            'user_id' => 1,
            'locale' => 'pl',
            'slug' => 'kompas',
            'title' => 'Kompas',
            'intro' => 'Zanim zaufasz – sprawdź.',
            'content' => "Kompas to projekt rozwijający narzędzia pomagające ludziom rozpoznawać manipulację, oszustwa i zagrożenia informacyjne oraz podejmować bezpieczne decyzje w świecie cyfrowym.
            Kompas to projekt społeczno-technologiczny rozwijany przez Fundację Goodway, którego celem jest zwiększanie odporności społeczeństwa na manipulację, oszustwa cyfrowe i zagrożenia informacyjne.
Pierwszym elementem projektu jest inteligentny analizator wiadomości, który pomaga użytkownikom oceniać podejrzane SMS-y, e-maile, wiadomości z komunikatorów oraz oferty internetowe.
System analizuje treść zgłoszenia, identyfikuje charakterystyczne cechy manipulacji oraz wskazuje potencjalne ryzyko zagrożenia wraz z rekomendowanymi działaniami.
Każde zgłoszenie pomaga również budować anonimową bazę wiedzy o aktualnych metodach wyłudzeń, oszustw i manipulacji pojawiających się w przestrzeni cyfrowej.
W kolejnych etapach Kompas będzie rozwijany jako platforma wspierająca edukację cyfrową, analizę zagrożeń, badania społeczne oraz budowanie odporności informacyjnej obywateli.
Naszym celem jest stworzenie miejsca, które pomaga ludziom podejmować bezpieczniejsze decyzje w świecie informacji, technologii i komunikacji.
            ",
            'result' => "",
            'site_description' => '',
            'site_keyword' => '',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
