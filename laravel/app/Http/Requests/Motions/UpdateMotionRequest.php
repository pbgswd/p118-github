<?php

namespace App\Http\Requests\Motions;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMotionRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'motion.title' => 'required|string|max:255',
            'motion.description' => 'string|required|max:10000',
            'motion.submission_type' => 'required|string',
        ];
    }
}
