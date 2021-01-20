<?php

namespace App\Http\Requests\CommitteePost;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UpdateCommitteePostRequest.
 *
 * @property mixed[] $post
 */
class UpdateCommitteePostRequest extends FormRequest
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
            'post.title' => 'required|max:255|unique:committee_posts,title,'.$this->route('any_committee_post')->slug.',slug',
            'post.content' => 'required',
            'post.sticky' => 'boolean',
            'post.allow_comments' => 'boolean',
            'post.live' => 'boolean',
        ];
    }
}
