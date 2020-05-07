<?php

namespace App\Http\Requests\Committees;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StoreCommitteeRequest
 *
 * @property mixed[] $committee
 */
class StoreCommitteeRequest extends FormRequest
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
            'committee.name' => 'required|unique:committees,name|max:255',
            'committee.description' => 'required',
            'committee.email' => 'string|max:255',
            'committee.access_level' => 'required|string|max:255',
            'committee.sort_order' =>  'required|numeric',
            'committee.in_menu' => 'boolean',
            'committee.live' => 'boolean',
        ];
    }
}
