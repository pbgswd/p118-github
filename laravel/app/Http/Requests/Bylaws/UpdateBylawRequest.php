<?php

namespace App\Http\Requests\Bylaws;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UpdateBylawRequest
 *
 * @property array $bylaw
 */
class UpdateBylawRequest extends FormRequest
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
            'bylaw.title' => 'required|max:255',
            'bylaw.description' => 'string',
            'bylaw.date' => 'date',
            'bylaw.live' => 'boolean',
        ];
    }
}
