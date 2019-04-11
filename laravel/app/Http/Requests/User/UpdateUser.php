<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUser extends FormRequest
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
            //unique:table,column,except,idColumn
            'user.name' => 'required|string|max:255',
            'user.email' => 'required|max:255|unique:users,email,' . $this->route('user')->id . ',id',

        ];
    }
}
