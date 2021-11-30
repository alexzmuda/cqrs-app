<?php

declare(strict_types=1);

namespace App\Modules\Product\Services\CQRS\Handlers;

use App\Exceptions\CommandInvalidException;
use App\Exceptions\InvalidParameterException;
use App\Infrastructure\CQRS\Command;
use App\Infrastructure\CQRS\CommandHandler;
use App\Infrastructure\CQRS\CommandRegistry;
use App\Infrastructure\CQRS\SupportedCommandValidator;
use App\Modules\Product\Models\Product;
use App\Modules\Product\Repositories\Interfaces\ProductRepository;
use App\Modules\Product\Services\CQRS\Commands\CreateProductCommand;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

final class CreateProductCommandHandler implements CommandHandler
{
    private ProductRepository $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    public static function handles(): string
    {
        return CreateProductCommand::class;
    }

    /**
     * @param Command|CreateProductCommand $command
     * @param CommandRegistry $registry
     * @return int|null
     * @throws CommandInvalidException
     * @throws InvalidParameterException
     */
    public function handle(Command $command, CommandRegistry $registry): ?int
    {
        (new SupportedCommandValidator($command, $this))();

        $entry = new Product([
            'name' => $command->productName()->getValue(),
            'code' => $command->productCode()->getValue(),
            'price' => $command->productPrice()->getValue(),
        ]);

        $this->repository->store($entry);

        return $entry->getKey();
    }
} 