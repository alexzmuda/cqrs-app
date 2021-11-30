<?php

declare(strict_types=1);

namespace App\Modules\Order\Services\CQRS\Commands;

use App\Infrastructure\CQRS\Command;
use App\Modules\Order\Models\Order;

final class DestroyOrderCommand implements Command
{
    private Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function getOrder(): Order
    {
        return $this->order;
    }
}