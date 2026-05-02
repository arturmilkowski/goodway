<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use Illuminate\View\View;
use App\Models\Page\Page;
use App\Models\Blog\Post\Post;
use App\Models\Project\Project;

class PageController extends Controller
{
    public function index(string $locale): View
    {
        $posts = Post::with(['translation'])
            ->approved()
            ->published()
            ->latest()
            ->get();

        $projects = Project::with(['translation'])
            ->latest()
            ->get();

        return view('page.index', [
            'posts'    => $posts,
            'projects' => $projects,
            'path'     => asset('storage'),
        ]);
    }

    public function show(string $locale, string $slug): View
    {
        $page = Page::whereHas(
            'translations',
            fn($q) =>
            $q->where('locale', app()->getLocale())
                ->where('slug', $slug)
        )->with(['translation'])->firstOrFail();

        return view('page.show', [
            'page' => $page,
            'path' => asset('storage'),
        ]);
    }
}
