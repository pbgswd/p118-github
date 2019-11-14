<?php

namespace App\Http\Requests\Venues;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVenue extends FormRequest
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
            'venue.user_id' => 'required|numeric'. $this->route('venue')->slug . ',slug',
            'venue.name' => 'required|unique:venues,name|max:255',
            'venue.description' => 'required|string',
            'venue.url' => 'string',
            'venue.access_level' => 'required|string|max:255',
            'venue.sort_order' =>  'required|numeric',
            'venue.in_menu' => 'boolean',
            'venue.live' => 'boolean',
        ];
    }
}
