<?php

namespace App\Http\Requests\InviteUser;

use Illuminate\Foundation\Http\FormRequest;

class ProcessUserRequest extends FormRequest
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
        return  [
            //'name' => 'required|max:255',
            //'email' => 'required|email|max:255|unique:users',
            'new_password' => 'required|min:6|confirmed',
        ];
        // dumbpwd|
    }
}
