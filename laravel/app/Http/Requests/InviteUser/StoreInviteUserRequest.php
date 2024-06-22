<?php

namespace App\Http\Requests\InviteUser;

use App\Traits\ModifiesInputTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreInviteUserRequest extends FormRequest
{
    use ModifiesInputTrait;

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
            'invite.name' => 'required|string|min:2|max:255',
            'invite.email' => 'required|email|min:6|max:255',
            'invite.membership_type' => 'required|string',
            'invite.message' => 'max:1024',
            'invite.role' => 'required|string',
        ];
    }

    protected function modifyInput(): void
    {
        $invite = \array_merge(
            $this->input('invite'),
            [
                'user_id' => Auth::id(),
            ]
        );

        $this->merge(['invite' => $invite]);
    }
}
