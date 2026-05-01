<?php

namespace App\Http\Controllers\Admin\Blog\Post;

use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Blog\Post\Post;
use App\Http\Requests\Admin\Blog\StorePostRequest;

class PostController
{
    private string $blogImgPath = 'images/blog';

    public function index(): Response
    {
        $posts = Post::with([
            'translations' => fn($q) =>
            $q->where('locale', 'pl')
                ->select('post_id', 'locale', 'title', 'slug')
        ])->latest()->get();

        return Inertia::render('admin/blog/post/Index', [
            'posts' => $posts,
            'path'  => asset('storage'),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('admin/blog/post/Create', [
            'locales' => config('settings.locales', ['pl', 'en']),
        ]);
    }

    public function store(StorePostRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $file = $request->file('imgFile');
        if ($file) {
            $path = $file->storePublicly($this->blogImgPath, 'public');
            $validated['img'] = $path;
        }

        $file1 = $request->file('imgFile1');
        if ($file1) {
            $path1 = $file1->storePublicly($this->blogImgPath, 'public');
            $validated['img1'] = $path1;
        }

        $post = Post::create([
            ...collect($validated)->except('translations')->toArray(),
            'user_id' => Auth::id(),
        ]);

        foreach ($validated['translations'] as $locale => $translation) {
            if (empty($translation['title']) || trim($translation['title']) === '') {
                continue;
            }

            $post->translations()->create([
                'locale'           => $locale,
                'user_id'          => Auth::id(),
                'slug'             => $translation['slug'],
                'title'            => $translation['title'],
                'intro'            => $translation['intro'] ?? null,
                'content'          => $translation['content'] ?? null,
                'site_description' => $translation['site_description'] ?? null,
                'site_keyword'     => $translation['site_keyword'] ?? null,
            ]);
        }

        Inertia::flash(['message' => 'Dodano']);

        return to_route('admin.blog.posts.index');
    }

    public function show(Post $post): Response
    {
        $post->load(['translations']);

        return Inertia::render('admin/blog/post/Show', [
            'post'    => $post,
            'locales' => config('settings.locales', ['pl', 'en']),
            'path'    => asset('storage'),
        ]);
    }

    public function edit(Post $post): Response
    {
        $post->load(['translations']);

        return Inertia::render('admin/blog/post/Edit', [
            'post'    => $post,
            'locales' => config('settings.locales', ['pl', 'en']),
            'path'    => asset('storage'),
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
            $path = $file->storePublicly($this->blogImgPath, 'public');
            $validated['img'] = $path;
        }

        $file1 = $request->file('imgFile1');
        if ($file1) {
            if ($post->img1) {
                Storage::disk('public')->delete($post->img1);
            }
            $path1 = $file1->storePublicly($this->blogImgPath, 'public');
            $validated['img1'] = $path1;
        }

        $post->update(collect($validated)->except('translations')->toArray());

        foreach ($validated['translations'] as $locale => $translation) {
            if (empty($translation['title']) || trim($translation['title']) === '') {
                continue;
            }

            $post->translations()->updateOrCreate(
                ['locale' => $locale],
                [
                    'user_id'          => Auth::id(),
                    'slug'             => $translation['slug'],
                    'title'            => $translation['title'],
                    'intro'            => $translation['intro'] ?? null,
                    'content'          => $translation['content'] ?? null,
                    'site_description' => $translation['site_description'] ?? null,
                    'site_keyword'     => $translation['site_keyword'] ?? null,
                ]
            );
        }

        Inertia::flash(['message' => 'Zmieniono']);

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

        Inertia::flash(['message' => 'Usunięto']);

        return to_route('admin.blog.posts.index');
    }
}
