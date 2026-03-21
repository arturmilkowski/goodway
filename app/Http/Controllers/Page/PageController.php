<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Page\Page;

class PageController extends Controller
{
    public function index(): View
    {
        return view('page.index');
    }

    public function show(Page $page): View
    {
        return view('page.show', ['page' => $page]);
    }
}
