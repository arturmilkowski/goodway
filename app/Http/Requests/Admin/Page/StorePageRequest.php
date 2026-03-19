<?php

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

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'user_id' => Auth::id(),
            'slug' => Str::slug($this->title),
        ]);
    }
}
