<?php

namespace App\Http\Requests\Meetings;

use App\Traits\ModifiesInputTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/**
 * Class StoreMeetingRequest.
 *
 * @property mixed[] $meeting
 */
class StoreMeetingRequest extends FormRequest
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
            'meeting.title' => 'string|required|max:255',
            'meeting.description' => 'string|nullable',
        ];
    }

    protected function modifyInput(): void
    {
        $meeting = \array_merge(
            $this->input('meeting'),
            [
                'user_id' => Auth::id(),
            ]
        );

        $this->merge(['meeting' => $meeting]);
    }
}
