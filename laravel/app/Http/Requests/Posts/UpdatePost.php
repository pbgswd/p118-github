<?php

namespace App\Http\Requests\Posts;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'post.title' => 'required|max:255|unique:posts,title,' . $this->route('post')->slug . ',slug',
            'post.description' => 'required',
            'post.content' => 'required',
            'post.access_level' => 'required|string|max:255',
            'post.sort_order' =>  'required|numeric',
            'post.in_menu' => 'boolean',
            'post.allow_comments' => 'boolean',
            'post.live' => 'boolean',
            'image' => 'image',
        ];
    }
}
