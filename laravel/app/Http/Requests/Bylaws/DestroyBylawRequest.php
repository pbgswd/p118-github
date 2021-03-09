<?php

namespace App\Http\Requests\Bylaws;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class DestroyBylawRequest.
 * @property int[] $id
 */
class DestroyBylawRequest extends FormRequest
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
            'id' => 'required|exists:bylaws',
        ];
    }
}
