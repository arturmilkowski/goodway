<?php

namespace App\Http\Controllers\Blog\Post;

use App\Models\Blog\Post\Post;

class PostController
{
    /*
    public function __invoke(string $slug)
    {
        // dd(app()->getLocale(), $slug);
        dd(app()->getLocale(), $slug);
        $post = Post::whereHas(
            'translations',
            fn($q) =>
            $q->where('locale', app()->getLocale())
                ->where('slug', $slug)
        )->with(['translation'])->firstOrFail();

        return view('blog.post.show', [
            'post' => $post,
            'path' => asset('storage'),
        ]);
    }
    */

    public function __invoke(string $locale, string $slug)
    {
        $post = Post::whereHas(
            'translations',
            fn($q) =>
            $q->where('locale', app()->getLocale())
                ->where('slug', $slug)
        )->with(['translation'])->firstOrFail();

        return view('blog.post.show', [
            'post' => $post,
            'path' => asset('storage'),
        ]);
    }
}
