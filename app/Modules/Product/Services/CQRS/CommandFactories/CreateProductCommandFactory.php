<?php

declare(strict_types=1);

namespace App\Modules\Product\Services\CQRS\CommandFactories;

use App\Modules\Product\Http\Requests\CreateProductRequest;
use App\Modules\Product\Services\CQRS\Commands\CreateProductCommand;

final class CreateProductCommandFactory
{
    public function createFromRequest(CreateProductRequest $request): CreateProductCommand
    {
        return new CreateProductCommand(
            $request->name,
            $request->code,
            $request->price
        );
    }
} 