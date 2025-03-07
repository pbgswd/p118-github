<?php

namespace App\Http\Requests\Motions;

use Illuminate\Foundation\Http\FormRequest;

class DestroyMotionRequest extends FormRequest
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
//todo admin, or the author only
        return [
            'id' => 'required',
        ];
    }
}
