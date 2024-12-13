<?php

namespace App\Http\Requests\Messages;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMessageRequest extends FormRequest
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
            //  //source_type[topic][] source_type[model][] source_type[committee][]
            'source_type.topic.*' => 'nullable|string',
            'source_type.model.*' => 'nullable|string',
            'source_type.committee.*' => 'nullable|string',
            'source_type.*.*' => 'required_without_all:source_type.topic.*,source_type.model.*,source_type.committee.*',
//todo fix form request validator
          //  'message.subject' => 'required|max:255|unique:messages,subject,'.$this->route('message')->slug.',slug',
            'message.content' => 'string|nullable',
        ];
    }
}
