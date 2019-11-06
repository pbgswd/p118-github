<?php

namespace App\Http\Requests\Attachments;

use Illuminate\Foundation\Http\FormRequest;

class StoreAttachment extends FormRequest
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
            // array of files?
          'images' => 'required',
          'images.*' => 'required|unique:attachments,name|max:255|distinct',

        ];
    }
}
