<?php

namespace App\Http\Requests\Contactlistdata;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactlistdataRequest extends FormRequest
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
            'cld.name' => 'required|max:255',
            'cld.street1' => 'max:255',
            'cld.street2' => 'max:255',
            'cld.city' => 'max:255',
            'cld.province' => 'max:255',
            'cld.postal_code' => 'max:16',
            'cld.country' => 'max:255',
            'cld.phone' => 'max:255',
            'cld.email' => 'max:255',
            'cld.website' => 'max:255',
            'cld.notes' => 'max:2000',
            'cld.access_level' => 'max:255',
            'cld.live' => 'boolean',
            'cld.contact' => 'max:255',
        ];
    }
}
