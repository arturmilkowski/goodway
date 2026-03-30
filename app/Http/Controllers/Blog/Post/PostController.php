<?php

namespace App\Http\Controllers\Blog\Post;

// use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
use App\Models\Blog\Post\Post;

class PostController // extends Controller
{
    public function __invoke(Post $post) // Request $request
    {
        return view('blog.post.show', ['post' => $post]);
    }
}
