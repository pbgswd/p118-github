<?php

namespace App\Http\Requests\CommitteeMember;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommitteeMember extends FormRequest
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
            //'id' => 'required|exists:user',
            'role' => 'required|string',
            //'committee_id' => 'required|int|exists:committees'
        ];
    }
}
