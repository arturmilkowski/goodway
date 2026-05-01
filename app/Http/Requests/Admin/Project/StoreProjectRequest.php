<?php

namespace App\Http\Requests\Admin\Project;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $existingTranslations = $this->project
            ? $this->project->translations->keyBy('locale')
            : collect();

        $locales = config('settings.locales', ['pl', 'en']);

        $rules = [
            'img'          => ['sometimes', 'nullable', 'string'],
            'img1'         => ['sometimes', 'nullable', 'string'],
            'imgFile'      => ['sometimes', 'nullable', 'image'],
            'imgFile1'     => ['sometimes', 'nullable', 'image'],
            'approved'     => ['boolean'],
            'hide'         => ['boolean'],
            'translations' => ['required', 'array'],
        ];

        foreach ($locales as $locale) {
            $translationId = $existingTranslations->get($locale)?->id;
            $isDefault = $locale === config('app.locale', 'pl');

            $rules["translations.{$locale}"]                  = ['sometimes', 'array'];
            $rules["translations.{$locale}.title"]            = [
                $isDefault ? 'required' : 'nullable',
                'string',
                'max:255',
                Rule::unique('project_translations', 'title')->ignore($translationId),
            ];
            $rules["translations.{$locale}.slug"]             = [
                $isDefault ? 'required' : 'nullable',
                'string',
                'max:255',
                Rule::unique('project_translations', 'slug')->ignore($translationId),
            ];
            $rules["translations.{$locale}.intro"]            = ['nullable', 'string', 'max:255'];
            $rules["translations.{$locale}.content"]          = ['nullable', 'string'];
            $rules["translations.{$locale}.result"]           = ['nullable', 'string'];
            $rules["translations.{$locale}.site_description"] = ['nullable', 'string', 'max:255'];
            $rules["translations.{$locale}.site_keyword"]     = ['nullable', 'string', 'max:255'];
        }

        return $rules;
    }

    protected function prepareForValidation(): void
    {
        $translations = $this->input('translations', []);
        $default = config('app.locale', 'pl');

        foreach ($translations as $locale => $translation) {
            if ($locale === $default) {
                if (empty($translation['slug']) && !empty($translation['title'])) {
                    $translations[$locale]['slug'] = Str::slug($translation['title']);
                }
            } else {
                if (empty(trim($translation['title'] ?? ''))) {
                    $translations[$locale] = [
                        'title'            => null,
                        'slug'             => null,
                        'intro'            => null,
                        'content'          => null,
                        'result'           => null,
                        'site_description' => null,
                        'site_keyword'     => null,
                    ];
                } else {
                    if (empty($translation['slug'])) {
                        $translations[$locale]['slug'] = Str::slug($translation['title']);
                    }
                }
            }
        }

        $this->merge([
            'translations' => $translations,
        ]);
    }

    public function attributes(): array
    {
        $attributes = [];
        $locales = config('settings.locales', ['pl', 'en']);
        $localeNames = ['pl' => 'PL', 'en' => 'EN', 'de' => 'DE'];

        foreach ($locales as $locale) {
            $lang = $localeNames[$locale] ?? strtoupper($locale);
            $attributes["translations.{$locale}.title"]            = "tytuł ({$lang})";
            $attributes["translations.{$locale}.slug"]             = "slug ({$lang})";
            $attributes["translations.{$locale}.intro"]            = "wstęp ({$lang})";
            $attributes["translations.{$locale}.content"]          = "cel ({$lang})";
            $attributes["translations.{$locale}.result"]           = "rezultat ({$lang})";
            $attributes["translations.{$locale}.site_description"] = "opis SEO ({$lang})";
            $attributes["translations.{$locale}.site_keyword"]     = "słowa kluczowe ({$lang})";
        }

        return $attributes;
    }
}
