<?php

namespace App\Http\Requests\Employment;

use Illuminate\Foundation\Http\FormRequest;


/**
 * Class UpdateEmploymentRequest
 * @property mixed[] $employment
 */
class UpdateEmploymentRequest extends FormRequest
{


    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'employment.title' => 'required|max:255',
            'employment.description' => 'string|nullable',
            'employment.url' => 'url|nullable',
            'employment.live' => 'boolean',
            'employment.deadline' => 'date',
        ];
    }
}
