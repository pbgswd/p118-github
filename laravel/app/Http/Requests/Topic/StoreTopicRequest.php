<?php

namespace App\Http\Requests\Topic;

use Illuminate\Foundation\Http\FormRequest;

class StoreTopicRequest extends FormRequest
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

        //$this->markTestSkipped(__FUNCTION__ . ' in ' . __FILE__ . ' cant be tested without context. Use Feature test');

        return [
            'topic.name' => 'required|unique:topics,name|max:255',
            'topic.access_level' => 'required|string|max:255',
            'topic.sort_order' =>  'required|numeric',
            'topic.live' => 'boolean',
            'topic.description' => 'string|max:255',
            'topic.front_page' => 'boolean',
            'topic.landing_page' => 'boolean',
        ];
    }
}
