<?php

namespace App\Http\Requests\CommitteePost;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class DestroyCommitteePostRequest.
 *
 * @property int[] $id
 */
class DestroyCommitteePostRequest extends FormRequest
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
            'id' => 'required|exists:committee_posts',
        ];
    }
}
