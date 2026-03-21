<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Page\Page;

class PageController //  extends Controller
{
    public function index(): View
    {
        $pages = Page::latest()->get();

        return view('page.index', ['pages'  => $pages]);
    }
}
