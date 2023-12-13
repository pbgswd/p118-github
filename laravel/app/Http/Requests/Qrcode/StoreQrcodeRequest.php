<?php

namespace App\Http\Requests\Qrcode;

use Illuminate\Foundation\Http\FormRequest;

class StoreQrcodeRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'qrcode.qrtype' => 'required',
            'qrcode.qrdata' => 'required|unique:qrcodes,qrdata|max:255',
            'qrcode.name' => 'required|unique:qrcodes,name|max:255',
        ];
    }
}
