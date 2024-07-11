<?php

namespace App\Http\Requests\Employment;

use Illuminate\Foundation\Http\FormRequest;

class QueryJobYearRequest extends FormRequest
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
            'year' => 'integer|required|digits:4',
        ];
    }
}
