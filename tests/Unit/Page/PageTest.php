<?php

namespace Tests\Unit\Page;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use App\Models\User;
use App\Models\Page\{Page, PageTranslation};

class PageTest extends TestCase
{
    use RefreshDatabase;

    private Page $page;
    private PageTranslation $pageTranslation;
    private Page $subpage;
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->page = Page::factory()->create([
            'user_id' => $this->user->id,
            // 'title' => 'Strona nadrzędna',
            // 'slug' => 'strona-nadrzedna',
            'parent_id' => null
        ]);

        $this->pageTranslation = PageTranslation::factory()
            ->for($this->page)
            ->for($this->user)
            ->create(['locale' => 'pl']);

        $this->subpage = Page::factory()->create([
            'user_id' => $this->user->id,
            // 'title' => 'Podstrona',
            // 'slug' => 'podstrona',
            'parent_id' => $this->page->id
        ]);
    }

    public function testMakePage(): void
    {
        $page = Page::factory()->make();

        $this->assertInstanceOf(Page::class, $page);
    }

    public function testCreatePage(): void
    {
        $user = User::factory()->create();
        $page = Page::factory()->for($user)->create();

        $this->assertModelExists($page);
        $this->assertDatabaseHas('pages', [
            // 'slug' => $page->slug,
            // 'title' => $page->title,
            // 'content' => $page->content,
        ]);
    }

    public function testPageBelongsToUser(): void
    {
        $user = User::factory()->create();
        $page = Page::factory()->for($user)->create();

        $this->assertInstanceOf(User::class, $page->user);
    }

    public function testPageBelongsToParent(): void
    {
        $this->assertInstanceOf(Page::class, $this->subpage->parent);
    }

    public function testPageHasManyChildren(): void
    {
        $this->assertInstanceOf(Collection::class, $this->page->children);
    }

    public function testPageHasChildren(): void
    {
        $this->assertTrue($this->page->hasChildren());
        $this->assertFalse($this->subpage->hasChildren());
    }

    public function testPageIsSubpage(): void
    {
        $this->assertTrue($this->subpage->isSubpage());
    }

    public function testPagePathAttribute(): void
    {
        $this->assertIsArray($this->subpage->getPathAttribute());
    }

    public function testPageHasManyPageTranslations(): void
    {
        $this->assertInstanceOf(Collection::class, $this->page->translations);
    }

    public function testPageHasOnePageTranslations(): void
    {
        $this->assertInstanceOf(PageTranslation::class, $this->page->translation);
    }
}
