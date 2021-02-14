<?php

namespace App\Http\Requests\Feature;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFeatureRequest extends FormRequest
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
            'delete_image' => 'boolean',
            'image' => 'file|nullable',
            // 'page.title' => 'required|max:255|unique:pages,title,'.$this->route('any_page')->slug.',slug',
            'feature.title' => 'required|max:255|unique:pages,title,'.$this->route('any_feature')->slug.',slug',
            'feature.content' => 'required',
            'feature.image' => 'string|nullable',
            'feature.file_name' => 'string|nullable',
            'feature.date' => 'date',
            'feature.live' => 'boolean',
        ];
    }
}
