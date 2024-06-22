<?php

namespace App\Http\Requests\Memoriam;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMemoriamRequest extends FormRequest
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
            'memoriam.title' => 'required|max:255|unique:memoriams,title,'.$this->route('any_memoriam')->slug.',slug',
            'memoriam.content' => 'string|nullable',
            'memoriam.live' => 'boolean',
            'image' => 'file|nullable',
            'memoriam.date' => 'date',
        ];
    }
}
