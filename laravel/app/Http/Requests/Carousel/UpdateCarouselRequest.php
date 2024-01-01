<?php

namespace App\Http\Requests\Carousel;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCarouselRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'carousel.caption' => 'string|required|nullable|max:255',
            'carousel.caption2' => 'string|nullable|max:255',
            'carousel.align' => 'string|nullable|max:255',
            'carousel.text_color' => 'string|nullable|max:255',
            'carousel.text_outline_color' => 'string|nullable|max:255',
            'carousel.live' => 'boolean',
            'carousel.order' => 'integer',
            'file.image_2000' => 'file|max:300|nullable',
            'file.image_1400' => 'file|max:300|nullable',
            'file.image_800' => 'file|max:100|nullable',
            'file.image_600' => 'file|max:100|nullable',
            'carousel.image_2000' => 'string|nullable|max:255',
            'carousel.file_2000' => 'string|nullable|max:255',
            'carousel.image_1400' => 'string|nullable|max:255',
            'carousel.file_1400' => 'string|nullable|max:255',
            'carousel.image_800' => 'string|nullable|max:255',
            'carousel.file_800' => 'string|nullable|max:255',
            'carousel.image_600' => 'string|nullable|max:255',
            'carousel.file_600' => 'string|nullable|max:255',
            'delete_image_2000' => 'boolean',
            'delete_image_1400' => 'boolean',
            'delete_image_800' => 'boolean',
            'delete_image_600' => 'boolean',
            'unset_outline_color' =>'boolean|nullable',
        ];
    }
}
