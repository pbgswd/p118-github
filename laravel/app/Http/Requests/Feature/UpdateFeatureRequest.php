<?php

namespace App\Http\Requests\Feature;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFeatureRequest extends FormRequest
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
            'delete_image' => 'boolean',
            'image' => 'file|nullable',
            'feature.title' => 'required|max:255|unique:pages,title,'.$this->route('any_feature')->slug.',slug',
            'feature.url' => 'string|nullable|max:255',
            'feature.content' => 'required',
            'feature.image' => 'string|nullable',
            'feature.file_name' => 'string|nullable',
            'feature.date' => 'date',
            'feature.live' => 'boolean',
            'feature.front_page' => 'boolean',
            'feature.landing_page' => 'boolean',
        ];
    }
}
