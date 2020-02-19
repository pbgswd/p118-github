<?php

namespace App\Http\Requests\Member;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMember extends FormRequest
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
            //unique:table,column,except,idColumn
            'user.name' => 'required|string|max:255',
            'user.email' => 'required|max:255|unique:users,email,' . $this->route('user')->id . ',id',
            'user_phone.phone_number' => 'required|max:255',
            'user_phone.label' => 'string|nullable',
            'user_phone.primary' => 'boolean',
            'user_info.share_email' => 'boolean',
            'user_info.share_phone' => 'boolean',
            'user_info.image' => 'string|nullable',
            'user_info.about' => 'string|nullable|max:2000',
            'user_address.unit' => 'max:255|nullable',
            'user_address.street' => 'string|required|max:255',
            'user_address.city' => 'string|required|max:255',
            'user_address.province' => 'string|required|max:255',
            'user_address.postal_code' => 'string|required|max:255',
            'user_address.country' => 'string|required|max:255',
        ];
    }
}
