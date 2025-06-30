<?php

namespace App\Http\Requests\Posts;

use Illuminate\Foundation\Http\FormRequest;

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
     */
    public function rules(): array
    {
        return [
            'post.title' => 'required|unique:posts,title|max:255',
            'post.content' => 'required',
            // 'post.access_level' => 'required|string|max:255',
            'post.live' => 'boolean',
            'post.landing_page' => 'boolean',
            'post.front_page' => 'boolean',
        ];
    }
}
