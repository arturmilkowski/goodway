<?php

namespace App\Http\Controllers\Admin\Page;

// use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Storage;
use App\Models\Page\Page;
use App\Http\Requests\Admin\Page\StorePageRequest;


class PageController // extends Controller
{
    private string $pageImgPath = 'images/page';

    public function index(): Response
    {
        $pages = Page::latest()->get();

        return Inertia::render('admin/page/Index', [
            'pages' => $pages,
            'path' => asset('storage')
        ]);
    }

    public function create(): Response
    {
        $pages = Page::latest()->get();

        return Inertia::render('admin/page/Create', [
            'pages' => $pages,
        ]);
    }

    public function store(StorePageRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $file = $request->file('imgFile');
        if ($file) {
            $path = $request->file('imgFile')->storePublicly($this->pageImgPath, 'public');
            $validated['img'] = $path;
        }

        $file1 = $request->file('imgFile1');
        if ($file1) {
            $path = $request->file('imgFile1')->storePublicly($this->pageImgPath, 'public');
            $validated['img1'] = $path;
        }

        Page::create($validated);

        Inertia::flash([
            'message' => 'Dodano',
        ]);

        return to_route('admin.pages.index');
    }

    public function show(Page $page): Response
    {
        /*
        $page->load(['children' => function ($query) {
            $query->orderBy('ordinal');
        }]);
        */

        /*
        $page->load(['parent', 'children' => function ($query) {
            $query->orderBy('ordinal');
        }]);
        */

        $page->load(['parent', 'children' => function ($query) {
            $query->where('hide', false)
                ->where('navbar', true)
                ->orderBy('ordinal');
        }]);

        return Inertia::render('admin/page/Show', [
            'page' => $page,
            'path' => asset('storage')
        ]);
    }

    public function edit(Page $page): Response
    {
        $pages = Page::latest()->get();

        return Inertia::render('admin/page/Edit', [
            'page' => $page,
            'pages' => $pages,
            'path' => asset('storage')
        ]);
    }

    public function update(StorePageRequest $request, Page $page): RedirectResponse
    {
        $validated = $request->validated();

        $file = $request->file('imgFile');
        if ($file) {
            if ($page->img) {
                Storage::disk('public')->delete($page->img);
            }
            $path = $request->file('imgFile')->storePublicly($this->pageImgPath, 'public');
            $validated['img'] = $path;
        }

        $file1 = $request->file('imgFile1');
        if ($file1) {
            if ($page->img1) {
                Storage::disk('public')->delete($page->img1);
            }
            $path1 = $request->file('imgFile1')->storePublicly($this->pageImgPath, 'public');
            $validated['img1'] = $path1;
        }

        $page->update($validated);

        Inertia::flash([
            'message' => 'Zmieniono',
        ]);

        return to_route('admin.pages.show', $page);
    }

    public function destroy(Page $page): RedirectResponse
    {
        if ($page->img) {
            Storage::disk('public')->delete($page->img);
        }
        if ($page->img1) {
            Storage::disk('public')->delete($page->img1);
        }

        $page->delete();

        Inertia::flash([
            'message' => 'Usunięto',
        ]);

        return to_route('admin.pages.index');
    }
}
