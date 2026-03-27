<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Page\Page;
use App\Models\Blog\Post\Post;
use App\Models\Project\Project;


class PageController extends Controller
{
    // private string $blogImgPath = 'images/blog';

    public function index(): View
    {
        $posts = Post::latest()->get(); // approved()->published()
        $projects = Project::latest()->get();

        return view('page.index', [
            'posts' => $posts,
            'projects'  => $projects,
            'path' => asset('storage'),
        ]);
    }

    public function show(Page $page): View
    {
        return view('page.show', ['page' => $page]);
    }
}
