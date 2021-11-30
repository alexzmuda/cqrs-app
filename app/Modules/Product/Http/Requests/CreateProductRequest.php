<?php

declare(strict_types=1);

namespace App\Modules\Product\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


/**
 * Class CreateProductRequest
 * @package App\Modules\Product\Http\Requests
 * @property-read string name
 * @property-read string code
 * @property-read string price
 */
final class CreateProductRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'code' => ['required', 'string'],
            'price' => ['required']
        ];
    }
}
