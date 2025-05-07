<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMemberAddress extends FormRequest
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
            // unique:table,column,except,idColumn
            'unit' => 'max:255|nullable',
            'street' => 'max:255|required',
            'city' => 'max:255|required',
            'province' => 'max:255|required',
            'postal_code' => 'max:255|required',
        ];
    }
}
