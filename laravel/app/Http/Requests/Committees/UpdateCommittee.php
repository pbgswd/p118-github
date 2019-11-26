<?php

namespace App\Http\Requests\Committees;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCommittee extends FormRequest
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
            'committee.name' => 'required|max:255|unique:committees,name,' . $this->route('committee')->slug . ',slug',
            'committee.description' => 'required',
            'committee.email' => 'string|max:255',
            'committee.access_level' => 'required|string|max:255',
            'committee.sort_order' =>  'required|numeric',
            'committee.in_menu' => 'boolean',
            'committee.allow_comments' => 'boolean',
            'committee.live' => 'boolean',
        ];
    }
}
