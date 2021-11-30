<?php

declare(strict_types=1);

namespace App\Modules\Product\Services\CQRS\CommandFactories;

use App\Modules\Product\Http\Requests\UpdateProductRequest;
use App\Modules\Product\Services\CQRS\Commands\UpdateProductCommand;
use Illuminate\Support\Facades\Auth;

final class UpdateProductCommandFactory
{
    public function createFromRequest(UpdateProductRequest $request): UpdateProductCommand
    {
        return new UpdateProductCommand(
            (int)$request->id,
            $request->name,
            $request->code,
            $request->price
        );
    }
}
