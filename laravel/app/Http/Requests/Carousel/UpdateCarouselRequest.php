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
            'carousel.button' => 'boolean',
            'carousel.link' => 'string|nullable|max:255',
            'carousel.align' => 'string|nullable|max:255',
            'carousel.text_color' => 'string|nullable|max:255',
            'carousel.color' => 'string|nullable|max:255',
            'carousel.live' => 'boolean',
            'carousel.order' => 'integer',
            'file.image_2000' => 'file|nullable',
            'file.image_1400' => 'file|nullable',
            'file.image_800' => 'file|nullable',
            'file.image_600' => 'file|nullable',
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
        ];
    }
}
