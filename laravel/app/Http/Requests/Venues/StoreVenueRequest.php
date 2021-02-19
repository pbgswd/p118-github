<?php

namespace App\Http\Requests\Venues;

use App\Traits\ModifiesInputTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreVenueRequest extends FormRequest
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
            'venue.name' => 'required|unique:venues,name|max:255',
            'venue.description' => 'required|string',
            'venue.url' => 'url|nullable',
            'venue.live' => 'boolean',
            'venue.admin_notes' => 'string|nullable',
            'venue.image' => 'string|nullable',
            'venue.file_name' => 'string|nullable',
        ];
    }

    protected function modifyInput(): void
    {
        $venue = \array_merge(
            $this->input('venue'),
            [
                'user_id' => Auth::id(),
            ]
        );

        $this->merge(['venue' => $venue]);
    }
}
