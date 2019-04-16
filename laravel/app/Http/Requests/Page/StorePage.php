<?php

namespace App\Http\Requests\Page;

use Illuminate\Foundation\Http\FormRequest;

class StorePage extends FormRequest
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
            'page.name' => 'required|unique:pages,name|max:255',
            'page.access_level' => 'required|string|max:255',
            'page.sort_order' =>  'required|numeric',
            'page.in_menu' => 'boolean',
            'page.allow_comments' => 'boolean',
            'page.live' => 'boolean',
            'image' => 'image',
        ];
    }
}
