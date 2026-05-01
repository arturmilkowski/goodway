<?php
/*
namespace App\Http\Requests\Admin\Page;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StorePageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'parent_id' =>  ['sometimes', 'nullable'],
            'slug' => ['required', 'max:255', Rule::unique('pages', 'slug')->ignore($this->page)],
            'title' => ['required', 'max:255', Rule::unique('pages', 'title')->ignore($this->page)],
            'intro' => ['nullable', 'string', 'max:255'],
            'content' => [],
            'img' => ['sometimes', 'nullable', 'string'],
            'img1' => ['sometimes', 'nullable', 'string'],
            'imgFile' => ['sometimes', 'nullable', 'image'],
            'imgFile1' => ['sometimes', 'nullable', 'image'],
            'site_description' => ['nullable', 'string', 'max:255'],
            'site_keyword' => ['nullable', 'string', 'max:255'],
            'navbar' => ['boolean'],
            'hide' => ['boolean'],
            'ordinal' => [''] // integer min:1
        ];
    }

    // Prepare the data for validation.
    protected function prepareForValidation(): void
    {
        $this->merge([
            'user_id' => Auth::id(),
            'slug' => Str::slug($this->title),
        ]);
    }
}
*/


namespace App\Http\Requests\Admin\Page;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StorePageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // ID bieżącego tłumaczenia per locale — potrzebne do unique()->ignore()
        // żeby przy edycji nie walidował unikalności przeciwko samemu sobie
        $existingTranslations = $this->page
            ? $this->page->translations->keyBy('locale')
            : collect();

        $locales = config('settings.locales', ['pl', 'en']);

        $rules = [
            // --- Pola głównej tabeli ---
            'parent_id'  => ['sometimes', 'nullable'],
            'img'        => ['sometimes', 'nullable', 'string'],
            'img1'       => ['sometimes', 'nullable', 'string'],
            'imgFile'    => ['sometimes', 'nullable', 'image'],
            'imgFile1'   => ['sometimes', 'nullable', 'image'],
            'navbar'     => ['boolean'],
            'hide'       => ['boolean'],
            'ordinal'    => ['integer', 'min:1', 'max:99'],

            // --- Tablica tłumaczeń jako całość ---
            'translations' => ['sometimes', 'nullable', 'array'],
        ];

        // --- Reguły per język ---
        foreach ($locales as $locale) {
            $translationId = $existingTranslations->get($locale)?->id;
            $isDefault = $locale === config('app.locale', 'pl');

            $rules["translations.{$locale}"]                  = ['sometimes', 'array'];
            $rules["translations.{$locale}.title"]             = [
                $isDefault ? 'required' : 'nullable',
                'string',
                'max:255',
                Rule::unique('page_translations', 'title')->ignore($translationId),
            ];
            $rules["translations.{$locale}.slug"]              = [
                $isDefault ? 'required' : 'nullable',
                'string',
                'max:255',
                Rule::unique('page_translations', 'slug')->ignore($translationId),
            ];
            $rules["translations.{$locale}.intro"]             = ['nullable', 'string', 'max:255'];
            $rules["translations.{$locale}.content"]           = ['nullable', 'string'];
            $rules["translations.{$locale}.site_description"]  = ['nullable', 'string', 'max:255'];
            $rules["translations.{$locale}.site_keyword"]      = ['nullable', 'string', 'max:255'];
        }

        return $rules;
    }

    /**
     * Prepare the data for validation.
     * Slug generowany automatycznie z title dla każdego języka osobno.
     */
    protected function prepareForValidation(): void
    {
        $translations = $this->input('translations', []);
        $default = config('app.locale', 'pl');

        foreach ($translations as $locale => $translation) {
            if ($locale === $default) {
                // Domyślny język — generuj slug z tytułu
                if (empty($translation['slug']) && !empty($translation['title'])) {
                    $translations[$locale]['slug'] = Str::slug($translation['title']);
                }
            } else {
                // Niedomyślny język — jeśli tytuł pusty, wyzeruj całe tłumaczenie
                if (empty(trim($translation['title'] ?? ''))) {
                    $translations[$locale] = [
                        'title'            => null,
                        'slug'             => null,
                        'intro'            => null,
                        'content'          => null,
                        'site_description' => null,
                        'site_keyword'     => null,
                    ];
                } else {
                    // Tytuł wypełniony — generuj slug jeśli brak
                    if (empty($translation['slug'])) {
                        $translations[$locale]['slug'] = Str::slug($translation['title']);
                    }
                }
            }
        }

        $this->merge([
            'user_id'      => Auth::id(),
            'translations' => $translations,
        ]);
    }

    /**
     * Czytelne nazwy pól w komunikatach błędów.
     */
    public function attributes(): array
    {
        $attributes = [];
        $locales = config('settings.locales', ['pl', 'en']);

        $localeNames = [
            'pl' => 'PL',
            'en' => 'EN',
            'de' => 'DE',
        ];

        foreach ($locales as $locale) {
            $lang = $localeNames[$locale] ?? strtoupper($locale);
            $attributes["translations.{$locale}.title"]            = "tytuł ({$lang})";
            $attributes["translations.{$locale}.slug"]             = "slug ({$lang})";
            $attributes["translations.{$locale}.intro"]            = "wstęp ({$lang})";
            $attributes["translations.{$locale}.content"]          = "zawartość ({$lang})";
            $attributes["translations.{$locale}.site_description"] = "opis SEO ({$lang})";
            $attributes["translations.{$locale}.site_keyword"]     = "słowa kluczowe ({$lang})";
        }

        return $attributes;
    }
}
