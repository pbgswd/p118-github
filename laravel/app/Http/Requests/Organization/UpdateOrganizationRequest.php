<?php

namespace App\Http\Requests\Organization;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UpdateOrganizationRequest.
 *
 * @property mixed[] $organization
 */
class UpdateOrganizationRequest extends FormRequest
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
    public function rules()
    {
        return [
            'organization.name' => 'required|max:255|unique:organizations,name,'.$this->route('any_organization')->slug.',slug',
            'organization.description' => 'required|string',
            'organization.url' => 'url|nullable',
            'organization.sort_order' =>  'required|numeric',
            'organization.in_menu' => 'boolean',
            'organization.live' => 'boolean',
        ];
    }
}
