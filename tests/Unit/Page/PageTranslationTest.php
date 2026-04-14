<?php

namespace Tests\Unit\Page;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Page\{Page,  PageTranslation};

class PageTranslationTest extends TestCase
{
    use RefreshDatabase;

    public function testMakePageTranslation(): void
    {
        $pageTranslation = PageTranslation::factory()->make();

        $this->assertInstanceOf(PageTranslation::class, $pageTranslation);
    }

    public function testCreatePageTranslation(): void
    {
        $user = User::factory()->create();
        $page = Page::factory()->for($user)->create();
        $pageTranslation = PageTranslation::factory()->for($user)->for($page)->create();

        $this->assertModelExists($pageTranslation);
        $this->assertDatabaseHas('page_translations', [
            'page_id' => $page->id,
            'user_id' => $user->id,
            'locale' => $pageTranslation->locale,
            'slug' => $pageTranslation->slug,
            'title' => $pageTranslation->title,
            'intro' => $pageTranslation->intro,
            'content' => $pageTranslation->content,
        ]);
    }
}
