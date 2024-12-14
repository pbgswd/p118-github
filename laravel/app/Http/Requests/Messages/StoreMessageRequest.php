<?php

namespace App\Http\Requests\Messages;

use Illuminate\Foundation\Http\FormRequest;

class StoreMessageRequest extends FormRequest
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
        $rules = [
            'message.subject' => 'required|max:255',
            'message.content' => 'string|required',
        ];

        if ($this->route()->parameter('message')) {
            $rules['message.subject'] .= '|unique:messages,subject,' . $this->route('message')->slug . ',slug,id,' . $this->route('message')->id;
        }

        return $rules;
    }
}
