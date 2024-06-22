<?php

namespace App\Http\Requests\User_Info;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserInfo extends FormRequest
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
            'user_info.share_email' => 'boolean',
            'user_info.share_phone' => 'boolean',
            'user_info.image' => 'string|nullable',
            'user_info.about' => 'string|max:2000|nullable',
        ];
    }
}
