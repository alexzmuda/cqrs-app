<?php

declare(strict_types=1);

namespace App\Modules\Order\Services\CQRS\CommandFactories;

use App\Modules\Order\Http\Requests\CreateOrderRequest;
use App\Modules\Order\Services\CQRS\Commands\CreateOrderCommand;
use Illuminate\Support\Facades\Auth;

final class CreateOrderCommandFactory
{
    public function createFromRequest(CreateOrderRequest $request): CreateOrderCommand
    {
        return new CreateOrderCommand(
            // Auth::user()->getKey(), // currently logged user
            $request->firstname,
            $request->lastname,
            $request->codes,
            $request->total_price
        );
    }
} 