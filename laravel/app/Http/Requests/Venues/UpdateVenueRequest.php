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
            'venue.name' => 'required|max:255|unique:venues,name,' . $this->route('any_venue')->slug . ',slug',
            'venue.description' => 'required|string',
            'venue.url' => 'url|nullable',
            //'venue.access_level' => 'required|string|max:255',
            'venue.sort_order' =>  'required|numeric',
            'venue.in_menu' => 'boolean',
            'venue.live' => 'boolean',
        ];
    }
    //todo set access_level in Request
}

