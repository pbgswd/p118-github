<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;


class UpdateUser extends FormRequest
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
            //unique:table,column,except,idColumn
            'user.name' => 'required|string|max:255',
            'user.email' => 'required|max:255|unique:users,email,' . $this->route('user')->id . ',id',
            'user_phone.phone_number' => 'required|max:255',
            'user_phone.label' => 'string|nullable',
            'user_phone.primary' => 'boolean',
            'user_info.share_email'=> 'boolean',
            'user_info.share_phone'=> 'boolean',
            'user_info.image'=> 'string|nullable',
            'user_info.about'=> 'string|nullable|max:2000',
            'user_address.unit' => 'max:255|nullable',
            'user_address.street'=> 'string|max:255|nullable',
            'user_address.city'=> 'string|max:255|nullable',
            'user_address.province'=> 'string|max:255|nullable',
            'user_address.postal_code'=> 'string|max:255|nullable',
            'user_address.country'=> 'string|max:255|nullable',
            'user_role' => 'required',
            /**
            'user_membership.membership_date' => 'date',
            'user_membership.membership_expires' => 'date',
            'user_membership.seniority_number' => 'required|integer|unique:memberships,seniority_number,'
             * . $this->route('user')->id . ',user_id',
            'user_membership.status' => 'string|required|max:255',
            'user_membership.admin_notes' => 'string|nullable|max:2000',
             **/
        ];
    }
}
