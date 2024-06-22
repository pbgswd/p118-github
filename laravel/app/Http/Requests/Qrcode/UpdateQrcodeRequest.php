<?php

namespace App\Http\Requests\Qrcode;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQrcodeRequest extends FormRequest
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
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'qrcode.qrtype' => 'required',
            'qrcode.qrdata' => 'required|max:255|unique:qrcodes,qrdata,'.$this->route('any_qrcode')->qrdata.',qrdata',
            'qrcode.name' => 'required|max:255|unique:qrcodes,name,'.$this->route('any_qrcode')->name.',name',
        ];
    }
}
