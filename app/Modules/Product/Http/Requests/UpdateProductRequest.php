<?php

declare(strict_types=1);

namespace App\Modules\Product\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


/**
 * Class UpdateProductRequest
 * @package App\Modules\Product\Http\Requests
 * @property-read int id
 * @property-read string name
 * @property-read string code
 * @property-read string price
 */
final class UpdateProductRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'id' => ['required', 'int'],
            'name' => ['required', 'string'],
            'code' => ['required', 'string'],
            'price' => ['required']
        ];
    }

}
