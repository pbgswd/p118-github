<?php

namespace App\Http\Requests\Faq;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFaqRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'faq.faq_topic' => 'required|max:255|unique:faqs,faq_topic,'.$this->route('any_faq')->slug.',slug',
            'faq.description' => 'required',
            'faq.access_level' => 'required|string|max:255',
            'faq.live' => 'boolean',
            'faq.faq_data.*.id' => 'integer|required',
            'faq.faq_data.*.faq_id' => 'integer|required',
            'faq.faq_data.*.question' => 'string|max:255|required',
            'faq.faq_data.*.answer' => 'string|nullable',
            'faq.faq_data.*.access_level' => 'string|max:255|nullable',
            'faq.faq_data.*.live' => 'boolean|nullable',
            'faq.faq_data.*.delete' => 'boolean|nullable',
            'faq.faq_data.*.sort_order' => 'string|nullable',
            'new.question' => 'string|max:255|nullable',
            'new.answer' => 'string|nullable',
            'new.access_level' => 'string|max:255|nullable',
            'new.live' => 'boolean|nullable',
            'new.sort_order' => 'string|nullable',
        ];
    }
}
