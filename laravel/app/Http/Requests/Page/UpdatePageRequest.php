<?php

namespace App\Http\Requests\Page;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UpdatePageRequest.
 *
 * @property mixed[] $page
 */
class UpdatePageRequest extends FormRequest
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
            'page.title' => 'required|max:255|unique:pages,title,'.$this->route('any_page')->slug.',slug',
            'page.content' => 'required',
            'page.access_level' => 'required|string|max:255',
            'page.live' => 'boolean',
            'page.front_page' => 'boolean',
            'page.landing_page' => 'boolean',
        ];
    }
}
