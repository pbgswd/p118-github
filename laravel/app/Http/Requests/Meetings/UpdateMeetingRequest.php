<?php

namespace App\Http\Requests\Meetings;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UpdateMeetingRequest.
 *
 * @property mixed[] $meeting
 */
class UpdateMeetingRequest extends FormRequest
{
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
            'meeting.title' => 'string|required|max:255',
            'meeting.description' => 'string|nullable',
            'meeting.date' => 'date|required',
            'meeting.time' => 'string|required',
            'meeting.meeting_type' => 'string|required',
        ];
    }
}
