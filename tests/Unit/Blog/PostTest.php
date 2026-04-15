<?php

namespace Tests\Unit\Blog;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use App\Models\User;
use App\Models\Blog\Post\{Post, PostTranslation};

class PostTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Post $post;
    private PostTranslation $postTranslation;


    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->post = Post::factory()->create(['user_id' => $this->user->id]);
        $this->postTranslation = PostTranslation::factory()
            ->for($this->user)
            ->for($this->post)
            ->create(['locale' => 'pl']);
    }

    public function testMakePost(): void
    {
        $post = Post::factory()->make();

        $this->assertInstanceOf(Post::class, $post);
    }

    public function testCreatePost(): void
    {
        $this->assertModelExists($this->post);

        $this->assertDatabaseHas('posts', [
            'user_id' => $this->user->id
        ]);
    }

    public function testPostBelongsToUser(): void
    {
        $this->assertInstanceOf(User::class, $this->post->user);
    }

    public function testPostHasManyPostTranslations(): void
    {
        $this->assertInstanceOf(Collection::class, $this->post->translations);
    }

    public function testPostHasOnePostTranslations(): void
    {
        $this->assertInstanceOf(PostTranslation::class, $this->post->translation);
    }
}
