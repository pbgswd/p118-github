<?php

namespace App\Http\Requests\Contact;

use Illuminate\Foundation\Http\FormRequest;

class SubmitContact extends FormRequest
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
            'email' => 'required|email|min:6|max:255',
            'name' => 'required|min:2|max:255',
            'mail_subject' => 'required|min:6|max:255',
            'mail_body' => 'required|min:6|max:2000',
            'g-recaptcha-response' => 'required',
        ];
    }
}
