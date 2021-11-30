<?php

declare(strict_types=1);

namespace App\Modules\Product\Services\CQRS\Handlers;

use App\Exceptions\CommandInvalidException;
use App\Exceptions\InvalidParameterException;
use App\Infrastructure\CQRS\Command;
use App\Infrastructure\CQRS\CommandHandler;
use App\Infrastructure\CQRS\CommandRegistry;
use App\Infrastructure\CQRS\SupportedCommandValidator;
use App\Modules\Product\Repositories\Interfaces\ProductRepository;
use App\Modules\Product\Services\CQRS\Commands\UpdateProductCommand;
use App\ValueObjects\Parameters\BoolParameter;
use App\ValueObjects\Parameters\IntParameter;
use App\ValueObjects\Parameters\StringParameter;

final class UpdateProductCommandHandler implements CommandHandler
{
    private ProductRepository $repository;

    public function __construct(
        ProductRepository $repository
    )
    {
        $this->repository = $repository;
    }

    public static function handles(): string
    {
        return UpdateProductCommand::class;
    }

    /**
     * @param Command|UpdateProductCommand $command
     * @param CommandRegistry $registry
     * @return int|null
     * @throws CommandInvalidException
     * @throws InvalidParameterException
     */
    public function handle(Command $command, CommandRegistry $registry): ?int
    {
        /** @var UpdateProductCommand $command */
        (new SupportedCommandValidator($command, $this))();

        $entry = $this->repository
            ->findById(
                $command->productId()->getValue()
            );

        if ($command->productName() instanceof StringParameter) {
            $entry->name = $command->productName()->getValue();
        }

        if ($command->productCode() instanceof StringParameter) {
            $entry->code = $command->productCode()->getValue();
        }

        if ($command->productPrice() instanceof StringParameter) {
            $entry->price = $command->productPrice()->getValue();
        }

        $this->repository->store($entry);

        return $entry->getKey();
    }
}
