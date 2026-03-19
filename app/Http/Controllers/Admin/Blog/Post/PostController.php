<?php

namespace App\Http\Controllers\Admin\Blog\Post;

// use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Storage;
use App\Models\Blog\Post\Post;
use App\Http\Requests\Admin\Blog\StorePostRequest;

class PostController // extends Controller
{
    private string $blogImgPath = 'images/blog';

    public function index(): Response
    {
        $posts = Post::latest()->get();

        return Inertia::render('admin/blog/post/Index', [
            'posts' => $posts,
            'path' => asset('storage')
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('admin/blog/post/Create');
    }

    public function store(StorePostRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $file = $request->file('imgFile');
        if ($file) {
            $path = $request->file('imgFile')->storePublicly($this->blogImgPath, 'public');
            $validated['img'] = $path;
        }

        $file1 = $request->file('imgFile1');
        if ($file1) {
            $path = $request->file('imgFile1')->storePublicly($this->blogImgPath, 'public');
            $validated['img1'] = $path;
        }

        Post::create($validated);

        Inertia::flash([
            'message' => 'Dodano',
        ]);

        return to_route('admin.blog.posts.index');
    }

    public function show(Post $post): Response
    {
        return Inertia::render('admin/blog/post/Show', [
            'post' => $post,
            'path' => asset('storage')
        ]);
    }

    public function edit(Post $post): Response
    {
        return Inertia::render('admin/blog/post/Edit', [
            'post' => $post,
            'path' => asset('storage')
        ]);
    }

    public function update(StorePostRequest $request, Post $post): RedirectResponse
    {
        $validated = $request->validated();

        $file = $request->file('imgFile');
        if ($file) {
            if ($post->img) {
                Storage::disk('public')->delete($post->img);
            }
            $path = $request->file('imgFile')->storePublicly($this->blogImgPath, 'public');
            $validated['img'] = $path;
        }

        $file1 = $request->file('imgFile1');
        if ($file1) {
            if ($post->img1) {
                Storage::disk('public')->delete($post->img1);
            }
            $path1 = $request->file('imgFile1')->storePublicly($this->blogImgPath, 'public');
            $validated['img1'] = $path1;
        }

        $post->update($validated);

        Inertia::flash([
            'message' => 'Zmieniono',
        ]);

        return to_route('admin.blog.posts.show', $post);
    }

    public function destroy(Post $post): RedirectResponse
    {
        if ($post->img) {
            Storage::disk('public')->delete($post->img);
        }
        if ($post->img1) {
            Storage::disk('public')->delete($post->img1);
        }

        $post->delete();

        Inertia::flash([
            'message' => 'Usunięto',
        ]);

        return to_route('admin.blog.posts.index');
    }
}
