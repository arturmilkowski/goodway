<?php

namespace App\Http\Requests\Admin\Project;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreProjectRequest extends FormRequest
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
            'slug' => ['required', 'max:255', Rule::unique('projects', 'slug')->ignore($this->project)],
            'title' => ['required', 'max:255', Rule::unique('projects', 'title')->ignore($this->project)],
            'intro' => ['nullable', 'string', 'max:255'],
            'content' => [],
            'result' => [],
            'img' => ['sometimes', 'nullable', 'string'],
            'img1' => ['sometimes', 'nullable', 'string'],
            'imgFile' => ['sometimes', 'nullable', 'image'],
            'imgFile1' => ['sometimes', 'nullable', 'image'],
            'site_description' => ['nullable', 'string', 'max:255'],
            'site_keyword' => ['nullable', 'string', 'max:255'],
            'approved' => ['boolean'],
            'hide' => ['boolean'],
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
