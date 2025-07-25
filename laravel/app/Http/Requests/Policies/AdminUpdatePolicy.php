<?php

namespace App\Http\Requests\Policies;

use Illuminate\Foundation\Http\FormRequest;

class AdminUpdatePolicy extends FormRequest
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
            'policy.title' => 'required|max:255',
            'policy.description' => 'required',
            'policy.date' => 'required|date',
            'policy.live' => 'boolean',
        ];
    }
}
