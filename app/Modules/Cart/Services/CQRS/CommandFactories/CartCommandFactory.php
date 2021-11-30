<?php

declare(strict_types=1);

namespace App\Modules\Cart\Services\CQRS\CommandFactories;

use App\Modules\Cart\Http\Requests\CartRequest;
use App\Modules\Cart\Services\CQRS\Commands\CartCommand;

final class CartCommandFactory
{
    public function calculate(CartRequest $request): CartCommand
    {
        return new CartCommand(
            $request->cart
        );
    }
} 