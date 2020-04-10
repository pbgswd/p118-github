<?php

namespace App\Http\Requests\Employment;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class DestroyEmploymentRequest
 *
 * @property int[] $id
 */
class DestroyEmploymentRequest extends FormRequest
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
            'id' => 'required|exists:employment',
        ];
    }
}
