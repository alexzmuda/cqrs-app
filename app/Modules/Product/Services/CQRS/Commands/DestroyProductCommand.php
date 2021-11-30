<?php

declare(strict_types=1);

namespace App\Modules\Product\Services\CQRS\Commands;

use App\Infrastructure\CQRS\Command;
use App\Modules\Product\Models\Product;

final class DestroyProductCommand implements Command
{
    private Product $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }
} 