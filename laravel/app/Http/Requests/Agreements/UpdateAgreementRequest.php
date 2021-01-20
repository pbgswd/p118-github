<?php

namespace App\Http\Requests\Agreements;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UpdateAgreementRequest.
 *
 * @property mixed[] $agreement
 */
class UpdateAgreementRequest extends FormRequest
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
            'agreement.title' => 'required|max:255',
            'agreement.from' => 'required|date',
            'agreement.until' => 'required|date',
            'agreement.live' => 'boolean',
        ];
    }
}
