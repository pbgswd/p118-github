<?php

namespace App\Http\Requests\Page;

use App\Traits\ModifiesInputTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/**
 * Class StorePageRequest.
 *
 * @property mixed[] $page
 */
class StorePageRequest extends FormRequest
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
            'page.title' => 'required|unique:pages,title|max:255',
            'page.description' => 'required',
            'page.content' => 'required',
            'page.access_level' => 'required|string|max:255',
            'page.sort_order' =>  'required|numeric',
            'page.in_menu' => 'boolean',
            'page.allow_comments' => 'boolean',
            'page.live' => 'boolean',
        ];
    }

    protected function modifyInput(): void
    {
        $page = \array_merge(
            $this->input('page'),
            [
                'user_id' => Auth::id(),
            ]
        );

        $this->merge(['page' => $page]);
    }
}
