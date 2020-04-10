<?php

namespace App\Http\Requests\Venues;

use App\Constants\AccessLevelConstants;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreVenueRequest extends FormRequest
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
            'venue.name' => 'required|unique:venues,name|max:255',
            'venue.description' => 'required|string',
            'venue.url' => 'url|nullable',
            'venue.sort_order' =>  'required|numeric',
            'venue.in_menu' => 'boolean',
            'venue.live' => 'boolean',
        ];
    }
    protected function modifyInput(): void
    {
        $venue = \array_merge(
            $this->input('venue'),
            [
                'user_id' => Auth::id()
            ]
        );

        $this->merge(['venue' => $venue]);
    }
}
