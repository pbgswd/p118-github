<?php

namespace App\Http\Requests\Faq;

use App\Traits\ModifiesInputTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreFaqRequest extends FormRequest
{
    use ModifiesInputTrait;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
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
            'faq.faq_topic' => 'required|unique:faqs,faq_topic|max:255',
            'faq.description' => 'required',
            'faq.access_level' => 'required|string|max:255',
            'faq.live' => 'boolean',
            'new.question' => 'string|max:255|nullable',
            'new.answer' => 'string|nullable',
            'new.access_level' => 'string|max:255|nullable',
            'new.live' => 'boolean|nullable',
            'new.sort_order' => 'string|nullable'
        ];
    }

    protected function modifyInput(): void
    {
        $faq = \array_merge(
            $this->input('faq'),
            [
                'user_id' => Auth::id(),
            ]
        );

        $this->merge(['faq' => $faq]);
    }
}
