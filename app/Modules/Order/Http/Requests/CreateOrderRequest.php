<?php

declare(strict_types=1);

namespace App\Modules\Order\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


/**
 * Class CreateOrderRequest
 * @package App\Modules\Order\Http\Requests
 * @property-read string firstname
 * @property-read string lastname
 * @property-read string codes
 * @property-read string total_price
 */
final class CreateOrderRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'firstname' => ['required', 'string'],
            'lastname' => ['required', 'string'],
            'codes' => ['required', 'string'],
            'total_price' => ['required']
        ];
    }
}
