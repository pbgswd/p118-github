<?php

namespace App\Http\Requests\Organization;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrganizationRequest extends FormRequest
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
            'organization.name' => 'required|unique:organizations,name|max:255',
            'organization.description' => 'required|string',
            'organization.url' => 'url|nullable',
            //'organization.access_level' => 'required|string|max:255',
            'organization.sort_order' =>  'required|numeric',
            'organization.in_menu' => 'boolean',
            'organization.live' => 'boolean',
        ];
    }
}
