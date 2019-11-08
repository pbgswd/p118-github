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
          'images' => 'required',
          //'mage.*' => 'unique:attachments,name|max:255|distinct',
        ];

        /* https://www.itsolutionstuff.com/post/laravel-validation-for-multiple-files-in-arrayexample.html
         * [
        'images.*' => 'required|mimes:jpg,jpeg,png,bmp|max:2000'
      ],[
        'images.*.required' => 'Please upload an image only',
        'images.*.mimes' => 'Only jpeg, png, jpg and bmp images are allowed',
        'images.*.max' => 'Sorry! Maximum allowed size for an image is 2MB',
    ]
         */
    }
}
