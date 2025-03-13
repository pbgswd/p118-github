<?php

namespace App\Http\Requests\FaqData;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFaqDataRequest extends FormRequest
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
            'faq_data.question' => 'string|max:255|required',
            'faq_data.answer' => 'string|required',
            'faq_data.access_level' => 'string|max:255|required',
            'faq_data.live' => 'boolean',
            'faq_data.sort_order' => 'integer|required',
        ];
    }
}
