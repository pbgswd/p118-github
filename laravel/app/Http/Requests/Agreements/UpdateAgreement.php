<?php

namespace App\Http\Requests\Agreements;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAgreement extends FormRequest
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
            'agreement.title' => 'required|max:255',
            'agreement.description' => 'string',
            'agreement.from' => 'required|date',
            'agreement.until' => 'required|date',
            'agreement.live' => 'boolean',
        ];
    }
}
