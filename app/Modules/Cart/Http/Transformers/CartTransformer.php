<?php

namespace App\Modules\Cart\Http\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class CartTransformer extends JsonResource
{
    /**
     * @return array
     */
    public function toArray($request)
    {
        return [
            'original_cart' => $request->cart,
            'calculated_cart' => $this['checkout'],
        ];
    }
}
