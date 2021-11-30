<?php

namespace App\Modules\Order\Services\CQRS\Queries;

use App\Infrastructure\CQRS\Query;

final class FetchOrderByIdQuery implements Query
{
    private int $orderId;

    public function __construct(int $orderId)
    {
        $this->orderId = $orderId;
    }

    public function getOrderId(): int
    {
        return $this->orderId;
    }
}