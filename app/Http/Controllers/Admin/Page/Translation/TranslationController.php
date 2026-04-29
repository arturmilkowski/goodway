<?php

namespace App\Http\Controllers\Admin\Page\Translation;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Page\Page;
use App\Models\Page\PageTranslation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class TranslationController
{
    /**
     * Formularz dodawania nowego tłumaczenia.
     * Locale przekazywane jako query param: /create?locale=en
     */
    public function create(Request $request, Page $page) //: Response
    {
        $locale = $request->query('locale', 'en');

        // Zabezpieczenie — nie pozwól dodać tłumaczenia które już istnieje
        if ($page->translations()->where('locale', $locale)->exists()) {
            return redirect()->route('admin.pages.show', $page);
        }

        return Inertia::render('admin/page/translation/Create', [
            'page'   => $page->only('id'),
            'locale' => $locale,
        ]);
    }

    /**
     * Zapis nowego tłumaczenia.
     */
    public function store(Request $request, Page $page): RedirectResponse
    {
        $validated = $request->validate([
            'locale'           => ['required', 'string', 'max:5', Rule::unique('page_translations')->where('page_id', $page->id)],
            'title'            => ['required', 'string', 'max:255', Rule::unique('page_translations', 'title')],
            'slug'             => ['nullable', 'string', 'max:255', Rule::unique('page_translations', 'slug')],
            'intro'            => ['nullable', 'string', 'max:255'],
            'content'          => ['nullable', 'string'],
            'site_description' => ['nullable', 'string', 'max:255'],
            'site_keyword'     => ['nullable', 'string', 'max:255'],
        ]);

        // Generuj slug z tytułu jeśli nie podano
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $page->translations()->create([
            ...$validated,
            'user_id' => Auth::id(),
        ]);

        Inertia::flash(['message' => 'Dodano tłumaczenie']);

        return to_route('admin.pages.show', $page);
    }

    /**
     * Formularz edycji istniejącego tłumaczenia.
     */
    public function edit(Page $page, PageTranslation $translation): Response
    {
        return Inertia::render('admin/page/translation/Edit', [
            'page'        => $page->only('id'),
            'translation' => $translation,
        ]);
    }

    /**
     * Aktualizacja istniejącego tłumaczenia.
     */
    public function update(Request $request, Page $page, PageTranslation $translation): RedirectResponse
    {
        $validated = $request->validate([
            'title'            => ['required', 'string', 'max:255', Rule::unique('page_translations', 'title')->ignore($translation->id)],
            'slug'             => ['nullable', 'string', 'max:255', Rule::unique('page_translations', 'slug')->ignore($translation->id)],
            'intro'            => ['nullable', 'string', 'max:255'],
            'content'          => ['nullable', 'string'],
            'site_description' => ['nullable', 'string', 'max:255'],
            'site_keyword'     => ['nullable', 'string', 'max:255'],
        ]);

        // Generuj slug z tytułu jeśli nie podano
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $translation->update([
            ...$validated,
            'user_id' => Auth::id(),
        ]);

        Inertia::flash(['message' => 'Zaktualizowano tłumaczenie']);

        return to_route('admin.pages.show', $page);
    }

    /**
     * Usunięcie tłumaczenia.
     * Zabezpieczenie — nie pozwól usunąć domyślnego języka.
     */
    public function destroy(Page $page, PageTranslation $translation): RedirectResponse
    {
        $defaultLocale = config('app.locale', 'pl');

        if ($translation->locale === $defaultLocale) {
            return back()->withErrors(['locale' => 'Nie można usunąć tłumaczenia w języku domyślnym.']);
        }

        $translation->delete();

        Inertia::flash(['message' => 'Usunięto tłumaczenie']);

        return to_route('admin.pages.show', $page);
    }
}
