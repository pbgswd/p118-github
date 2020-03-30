<?php

namespace App\Http\Requests\CommitteePostComment;

use Illuminate\Foundation\Http\FormRequest;

class DestroyCommitteePostCommentRequest extends FormRequest
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
            'id' => 'required|exists:committee_post_comments',
        ];
    }
}
