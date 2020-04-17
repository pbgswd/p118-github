<?php

namespace App\Http\Requests\CommitteePost;

use App\Traits\ModifiesInputTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/**
 * Class StoreCommitteePostRequest
 *
 * @property mixed[] $post
 */
class StoreCommitteePostRequest extends FormRequest
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
            'post.title' => 'required|unique:committee_posts,title|max:255',
            'post.content' => 'required',
            'post.sticky' => 'boolean',
            'post.allow_comments' => 'boolean',
            'post.live' => 'boolean',
        ];
    }

    protected function modifyInput(): void
    {
        $post = \array_merge(
            $this->input('post'),
            [
                'user_id' => Auth::id(),
            ]
        );
        $this->merge(['post' => $post]);
    }
}
