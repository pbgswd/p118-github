<?php

namespace App\Http\Requests\Carousel;

use Illuminate\Foundation\Http\FormRequest;

class StoreCarouselRequest extends FormRequest
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
            'file.image_2000' => 'file|nullable',
            'file.image_1400' => 'file|nullable',
            'file.image_800' => 'file|nullable',
            'file.image_600' => 'file|nullable',
        ];
    }
}
