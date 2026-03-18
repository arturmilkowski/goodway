<?php

namespace Tests\Unit\Blog;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use App\Models\User;
use App\Models\Blog\Post\Post;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function testMakePost(): void
    {
        $post = Post::factory()->make();

        $this->assertInstanceOf(Post::class, $post);
    }

    public function testCreatePost(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->for($user)->create();

        $this->assertModelExists($post);
        $this->assertDatabaseHas('posts', [
            'slug' => $post->slug,
            'title' => $post->title,
            'content' => $post->content,
        ]);
    }
}
