<?php

namespace App\Http\Requests\Member;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMemberEmergencyContact extends FormRequest
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
            'emergency_contact_name' => 'max:255',
            'emergency_contact_relationship' => 'max:255',
            'emergency_contact_phone' => 'required|min:10',
            'message' => 'max:2000',
        ];
    }
}
