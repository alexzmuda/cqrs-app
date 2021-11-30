<?php

namespace App\Modules\Cart\Services\CQRS\Commands;

use App\Infrastructure\CQRS\Command;

final class CartCommand implements Command
{
    private $cart;

    public function __construct(
        array $cart,
    )

    {
        $this->cart = $cart;
    }

    public function cart()
    {
        return $this->cart;
    }
}