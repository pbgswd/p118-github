<?php

namespace App\Http\Requests\Agreements;

use App\Traits\ModifiesInputTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/**
 * Class StoreAgreementRequest.
 *
 * @property mixed[] $agreement
 */
class StoreAgreementRequest extends FormRequest
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
            'agreement.title' => 'required|max:255',
            'agreement.from' => 'date',
            'agreement.until' => 'date',
            'agreement.live' => 'boolean',
        ];
    }

    protected function modifyInput(): void
    {
        $agreement = \array_merge(
            $this->input('agreement'),
            [
                'user_id' => Auth::id(),
            ]
        );
        $this->merge(['agreement' => $agreement]);
    }
}
