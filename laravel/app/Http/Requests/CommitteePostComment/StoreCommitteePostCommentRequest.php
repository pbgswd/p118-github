<?php

namespace App\Http\Requests\CommitteePostComment;

use App\Traits\ModifiesInputTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreCommitteePostCommentRequest extends FormRequest
{
    use ModifiesInputTrait;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize():bool
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
            'comment.content' => 'required',
        ];
    }

    protected function modifyInput(): void
    {
        $comment = \array_merge(
            $this->input('comment'),
            [
                'user_id' => Auth::id(),
            ]
        );
        $this->merge(['comment' => $comment]);
    }
}
