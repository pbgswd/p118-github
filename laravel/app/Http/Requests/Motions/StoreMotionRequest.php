<?php

namespace App\Http\Requests\Motions;

use App\Traits\ModifiesInputTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreMotionRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'motion.title' => 'required|string|max:255',
            'motion.description' => 'string|required|max:10000',
            'motion.submission_type' => 'required|string',
        ];
    }

    protected function modifyInput(): void
    {
        $motion = \array_merge(
            $this->input('motion'),
            [
                'user_id' => Auth::user()->id,
            ]
        );

        $this->merge(['motion' => $motion]);
    }
}
