<?php

namespace App\Http\Requests\Employment;

use App\Traits\ModifiesInputTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/**
 * Class StoreEmploymentRequest.
 *
 * @property mixed[] $employment
 */
class StoreEmploymentRequest extends FormRequest
{
    use ModifiesInputTrait;

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
            'employment.title' => 'required|max:255',
            'employment.description' => 'string|nullable',
            'employment.url' => 'url|nullable',
            'employment.live' => 'boolean',
            'employment.deadline' => 'date',
        ];
    }

    protected function modifyInput(): void
    {
        $employment = \array_merge(
            $this->input('employment'),
            [
                'user_id' => Auth::id(),
            ]
        );
        $this->merge([
            'employment' => $employment, ]);
    }
}
