<?php

namespace App\Http\Requests\Page;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class DestroyPageRequest.
 *
 * @property mixed[] $id
 */
class DestroyPageRequest extends FormRequest
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
            'id' => 'required',
        ];
    }
}
