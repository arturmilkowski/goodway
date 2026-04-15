<?php

namespace Tests\Unit\Blog;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Blog\Post\{Post, PostTranslation};

class PostTranslationTest extends TestCase
{
    use RefreshDatabase;

    public function testMakePostTranslation(): void
    {
        $postTranslation = PostTranslation::factory()->make();

        $this->assertInstanceOf(PostTranslation::class, $postTranslation);
    }

    public function testCreatePostTranslation(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->for($user)->create();
        $postTranslation = PostTranslation::factory()->for($user)->for($post)->create();

        $this->assertModelExists($postTranslation);
        $this->assertDatabaseHas('post_translations', [
            'post_id' => $post->id,
            'user_id' => $user->id,
            'locale' => $postTranslation->locale,
            'slug' => $postTranslation->slug,
            'title' => $postTranslation->title,
            'intro' => $postTranslation->intro,
            'content' => $postTranslation->content,
        ]);
    }

    public function testPostTranslationBelongsToUser(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->for($user)->create();
        $postTranslation = PostTranslation::factory()->for($user)->for($post)->create();

        $this->assertInstanceOf(User::class, $postTranslation->user);
    }

    public function testPostTranslationBelongsToPost(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->for($user)->create();
        $postTranslation = PostTranslation::factory()->for($user)->for($post)->create();

        $this->assertInstanceOf(Post::class, $postTranslation->post);
    }
}
