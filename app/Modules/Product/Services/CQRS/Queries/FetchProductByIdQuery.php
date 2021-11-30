<?php

namespace App\Modules\Product\Services\CQRS\Queries;

use App\Infrastructure\CQRS\Query;

final class FetchProductByIdQuery implements Query
{
    private int $productId;

    public function __construct(int $productId)
    {
        $this->productId = $productId;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }
}
