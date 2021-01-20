<?php

namespace App\Http\Requests\Organization;

use App\Traits\ModifiesInputTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/**
 * Class StoreOrganizationRequest.
 *
 * @property mixed[] $organization
 */
class StoreOrganizationRequest extends FormRequest
{
    use ModifiesInputTrait;

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
            'organization.sort_order' =>  'required|numeric',
            'organization.in_menu' => 'boolean',
            'organization.live' => 'boolean',
        ];
    }

    protected function modifyInput(): void
    {
        $organization = \array_merge(
            $this->input('organization'),
            [
                'user_id' => Auth::id(),
            ]
        );

        $this->merge(['organization' => $organization]);
    }
}
