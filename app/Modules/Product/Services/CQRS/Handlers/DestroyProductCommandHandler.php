<?php

declare(strict_types=1);

namespace App\Modules\Product\Services\CQRS\Handlers;

use App\Infrastructure\CQRS\Command;
use App\Infrastructure\CQRS\CommandHandler;
use App\Infrastructure\CQRS\CommandRegistry;
use App\Infrastructure\CQRS\SupportedCommandValidator;
use App\Modules\Product\Models\Product;
use App\Modules\Product\Repositories\Interfaces\ProductRepository;
use App\Modules\Product\Services\CQRS\Commands\DestroyProductCommand;

final class DestroyProductCommandHandler implements CommandHandler
{
    private ProductRepository $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    public static function handles(): string
    {
        return DestroyProductCommand::class;
    }

    /**
     * @param Command|DestroyProductCommand $command
     * @param CommandRegistry $registry
     * @return string|null
     *
     * @todo while implementing rest of profiles CRUD trigger deleting here as well
     * @see Product::entry()
     */
    public function handle(Command $command, CommandRegistry $registry): ?int
    {
        (new SupportedCommandValidator($command, $this))();

        $this->repository
            ->delete($command->getProduct());

        return null;
    }
} 