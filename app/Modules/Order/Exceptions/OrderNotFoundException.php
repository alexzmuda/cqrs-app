<?php

declare(strict_types=1);

namespace App\Modules\Order\Exceptions;

final class OrderNotFoundException extends \Exception
{
    public function __construct(int $orderId)
    {
        $message = sprintf('Order with ID: %s does not exist', $orderId);

        parent::__construct($message);
    }
}
