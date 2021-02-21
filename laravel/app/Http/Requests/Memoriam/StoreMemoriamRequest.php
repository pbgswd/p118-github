<?php

namespace App\Http\Requests\Memoriam;

use App\Traits\ModifiesInputTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreMemoriamRequest extends FormRequest
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
            'memoriam.title' => 'required|unique:memoriams,title|max:255',
            'memoriam.content' => 'string|nullable',
            'memoriam.live' => 'boolean',
            'image' => 'file|nullable',
            'memoriam.date' => 'date',
        ];
    }
    protected function modifyInput(): void
    {
        $memoriam = \array_merge(
            $this->input('memoriam'),
            [
                'user_id' => Auth::id(),
            ]
        );

        $this->merge(['memoriam' => $memoriam]);
    }
}
