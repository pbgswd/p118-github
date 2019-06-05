<?php

namespace App\Http\Requests\User_Info;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserInfo extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'user_info.share_email'=> 'boolean',
            'user_info.share_phone'=> 'boolean',
            'user_info.image'=> 'string|nullable',
            'user_info.about'=> 'string|max:2000|nullable',
        ];
    }
}
