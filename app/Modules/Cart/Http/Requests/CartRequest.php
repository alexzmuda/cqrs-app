<?php

declare(strict_types=1);

namespace App\Modules\Cart\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


/**
 * Class CreateOrderRequest
 * @package App\Modules\Order\Http\Requests
 * @property-read array cart
 */
final class CartRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'cart' => [],
        ];
    }
}
