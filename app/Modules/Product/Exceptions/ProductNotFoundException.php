<?php

declare(strict_types=1);

namespace App\Modules\Product\Exceptions;

final class ProductNotFoundException extends \Exception
{
    public function __construct(int $orderId)
    {
        $message = sprintf('Product with ID: %s does not exist', $orderId);

        parent::__construct($message);
    }
}
