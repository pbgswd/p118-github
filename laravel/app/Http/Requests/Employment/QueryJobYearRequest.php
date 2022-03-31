<?php

namespace App\Http\Requests\Employment;

use Illuminate\Foundation\Http\FormRequest;

class QueryJobYearRequest extends FormRequest
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
            'deadline' => 'integer|required|digits:4',
        ];
    }
}
