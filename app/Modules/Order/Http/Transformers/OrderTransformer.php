<?php

namespace App\Modules\Order\Http\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderTransformer extends JsonResource
{
    /**
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => (int) $this->id,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'codes' => $this->codes,
            'price' => (float) $this->total_price
        ];
    }
}
