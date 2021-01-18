<?php

namespace App\Http\Requests\Topic;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTopicRequest extends FormRequest
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
 //unique:table,column,except,idColumn
            'topic.name' => 'required|max:255|unique:topics,name,'.$this->route('any_topic')->slug.',slug',
            'topic.access_level' => 'required|string|max:255',
            'topic.sort_order' =>  'required|numeric',
            'topic.in_menu' => 'boolean',
            'topic.allow_comments' => 'boolean',
            'topic.live' => 'boolean',
        ];
    }
}
