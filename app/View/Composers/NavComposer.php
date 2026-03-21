<?php

namespace App\View\Composers;

//use App\Repositories\UserRepository;
use Illuminate\View\View;
use App\Models\Page\Page;

class NavComposer
{
    /**
     * Create a new profile composer.
     */
    public function __construct() {}

    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $pages = Page::latest()->navbar()->notHide()->orderBy('ordinal')->get();

        $view->with('pages', $pages);
    }
}
