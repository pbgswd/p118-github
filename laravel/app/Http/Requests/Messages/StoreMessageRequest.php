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
        return [
            //source_type[topic][] source_type[model][] source_type[committee][]

            'source_type.topic.*' => 'nullable|string',
            'source_type.model.*' => 'nullable|string',
            'source_type.committee.*' => 'nullable|string',
            'source_type.*.*' => 'required_without_all:source_type.topic.*,source_type.model.*,source_type.committee.*',
            'message.subject' => 'required|unique:messages,subject|max:255',
            'message.content' => 'string|required',
        ];
    }
}
