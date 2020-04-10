<?php

namespace App\Http\Requests\Meetings;

use App\Constants\AccessLevelConstants;
use App\Traits\ModifiesInputTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/**
 * Class StoreMeetingRequest
 * @package App\Http\Requests\Meetings
 */
class StoreMeetingRequest extends FormRequest
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
