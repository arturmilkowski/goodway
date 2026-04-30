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
use Illuminate\Support\Facades\Auth;


class PageController // extends Controller
{
    private string $pageImgPath = 'images/page';

    public function index(): Response
    {
        $pages = Page::with([
            'translations' => fn($q) =>
            $q->where('locale', 'pl')
                ->select('page_id', 'locale', 'title', 'slug')
        ])->latest()->get();

        return Inertia::render('admin/page/Index', [
            'pages' => $pages,
            'path'  => asset('storage'),
        ]);
    }

    public function create(): Response
    {
        $pages = Page::with([
            'translations' => fn($q) =>
            $q->where('locale', 'pl')
                ->select('page_id', 'locale', 'title', 'slug')
        ])->latest()->get();

        return Inertia::render('admin/page/Create', [
            'pages'   => $pages,
            'locales' => config('settings.locales', ['pl', 'en']),
        ]);
    }

    public function store(StorePageRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['user_id'] =  Auth::id();

        $file = $request->file('imgFile');
        if ($file) {
            $path = $file->storePublicly($this->pageImgPath, 'public');
            $validated['img'] = $path;
        }

        $file1 = $request->file('imgFile1');
        if ($file1) {
            $path1 = $file1->storePublicly($this->pageImgPath, 'public');
            $validated['img1'] = $path1;
        }

        $page = Page::create(
            collect($validated)->except('translations')->toArray()
        );

        foreach ($validated['translations'] as $locale => $translation) {
            if (empty($translation['title']) || trim($translation['title']) === '') {
                continue;
            }

            $page->translations()->create([
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

        Inertia::flash([
            'message' => 'Dodano',
        ]);

        return to_route('admin.pages.index');
    }

    public function show(Page $page): Response
    {
        $page->load([
            'translations',
            'parent',
            'children' => fn($q) => $q->where('hide', false)
                ->where('navbar', true)
                ->orderBy('ordinal'),
        ]);

        return Inertia::render('admin/page/Show', [
            'page'    => $page,
            'locales' => config('settings.locales', ['pl', 'en']),
            'path'    => asset('storage'),
        ]);
    }

    public function edit(Page $page): Response
    {
        $page->load(['translations']);

        $pages = Page::with([
            'translations' => fn($q) =>
            $q->where('locale', 'pl')
                ->select('page_id', 'locale', 'title', 'slug')
        ])->latest()->get();

        return Inertia::render('admin/page/Edit', [
            'page' => $page,
            'pages' => $pages,
            'locales' => ['pl', 'en'],
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
            $path = $file->storePublicly($this->pageImgPath, 'public');
            $validated['img'] = $path;
        }

        $file1 = $request->file('imgFile1');
        if ($file1) {
            if ($page->img1) {
                Storage::disk('public')->delete($page->img1);
            }
            $path1 = $file1->storePublicly($this->pageImgPath, 'public');
            $validated['img1'] = $path1;
        }

        $page->update(collect($validated)->except('translations')->toArray());

        foreach ($validated['translations'] as $locale => $translation) {
            if (empty($translation['title']) || trim($translation['title']) === '') {
                continue;
            }

            $page->translations()->updateOrCreate(
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
