<?php

namespace App\Http\Requests\Bylaws;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreBylawRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'bylaw.title' => 'required|max:255',
            'bylaw.description' => 'string',
            'bylaw.date' => 'date',
            'bylaw.live' => 'boolean',
        ];
    }

    protected function modifyInput(): void
    {
        $bylaw = \array_merge(
            $this->input('bylaw'),
            [
                'user_id' => Auth::id(),
            ]
        );
        $this->merge(['bylaw' => $bylaw]);
    }
}
