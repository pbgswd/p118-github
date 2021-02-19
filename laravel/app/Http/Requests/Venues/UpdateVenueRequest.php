<?php

namespace App\Http\Requests\Venues;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVenueRequest extends FormRequest
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
            'venue.name' => 'required|max:255|unique:venues,name,'.$this->route('any_venue')->slug.',slug',
            'venue.description' => 'required|string',
            'venue.url' => 'url|nullable',
            'venue.live' => 'boolean',
            'venue.admin_notes' => 'string|nullable',
            'venue.image' => 'string|nullable',
            'venue.file_name' => 'string|nullable',
        ];
    }
}
