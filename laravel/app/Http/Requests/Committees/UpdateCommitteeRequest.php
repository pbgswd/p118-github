<?php

namespace App\Http\Requests\Committees;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UpdateCommittee.
 *
 * @property mixed[] $committee
 */
class UpdateCommitteeRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'committee.name' => 'required|max:255|unique:committees,name,'.$this->route('any_committee')->slug.',slug',
            'committee.description' => 'required',
            'committee.email' => 'string|max:255',
            'committee.image' => 'file|nullable',
            'committee.live' => 'boolean',
        ];
    }
}
