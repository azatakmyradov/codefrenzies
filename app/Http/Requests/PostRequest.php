<?php

namespace App\Http\Requests;

use App\Models\Post;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $post = $this->route('post') ? $this->route('post') : new Post();

        return [
            'title' => ['required'],
            'slug' => ['required', Rule::unique('posts', 'slug')->ignore($this->route('post') ?: null)],
            'seo_description' => ['required'],
            'thumbnail' => ['required'],
            'category_id' => ['required', 'exists:categories,id'],
            'body' => ['required'],
            'published_at' => $post?->published_at !== null ? [] : ['nullable', 'after:' . now()]
        ];
    }
}
