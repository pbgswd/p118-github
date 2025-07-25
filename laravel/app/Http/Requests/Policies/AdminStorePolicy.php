<?php

namespace App\Http\Requests\Policies;

use App\Traits\ModifiesInputTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AdminStorePolicy extends FormRequest
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
            'policy.title' => 'required|max:255',
            'policy.description' => 'required',
            'policy.date' => 'date',
            'policy.live' => 'boolean',
        ];
    }

    protected function modifyInput(): void
    {
        $policy = \array_merge(
            $this->input('policy'),
            [
                'user_id' => Auth::id(),
            ]
        );
        $this->merge(['policy' => $policy]);
    }
}
