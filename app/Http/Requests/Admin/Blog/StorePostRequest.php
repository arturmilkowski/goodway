<?php

namespace App\Http\Requests\Admin\Blog;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StorePostRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'slug' => ['required', 'max:255', Rule::unique('posts', 'slug')->ignore($this->post)],
            'title' => ['required', 'max:255', Rule::unique('posts', 'title')->ignore($this->post)],
            'intro' => ['nullable', 'string', 'max:255'],
            'content' => [],
            'img' => ['sometimes', 'nullable', 'string'],
            'img1' => ['sometimes', 'nullable', 'string'],
            'imgFile' => ['sometimes', 'nullable', 'image'],
            'imgFile1' => ['sometimes', 'nullable', 'image'],
            'site_description' => ['nullable', 'string', 'max:255'],
            'site_keyword' => ['nullable', 'string', 'max:255'],
            'approved' => ['boolean'],
            'published' => ['boolean'],
            'comments_allowed' => ['boolean']
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
