<?php

namespace App\Http\Requests\Faq;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFaqRequest extends FormRequest
{

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
    public function rules()
    {
        //todo the array of faq._faq_data[]
        return [
            'faq.faq_topic' => 'required|max:255|unique:faqs,faq_topic,'.$this->route('any_faq')->slug.',slug',
            'faq.description' => 'required',
            'faq.access_level' => 'required|string|max:255',
            'faq.live' => 'boolean',




            'faq.faq_data.new.question' => 'string|max:255|nullable',
            'faq.faq_data.new.answer' => 'string|nullable',
            'faq.faq_data.new.access_level' => 'string|max:255|nullable',
            'faq.faq_data.new.live' => 'boolean|nullable',
            'faq.faq_data.new.sort_order' => 'string|nullable'



        ];
    }
}
