<?php

namespace App\Http\Requests\InviteUser;

use Illuminate\Foundation\Http\FormRequest;

class StoreInviteUserRequest extends FormRequest
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
            'invite.name' => 'required|string|min:2|max:255',
            'invite.email' => 'required|email|min:6|max:255',
            'user_role'  => 'required|string',
        ];
    }
}
