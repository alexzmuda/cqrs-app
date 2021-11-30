<?php

declare(strict_types=1);

namespace App\Modules\Order\Services\CQRS\Handlers;

use App\Infrastructure\CQRS\Command;
use App\Infrastructure\CQRS\CommandHandler;
use App\Infrastructure\CQRS\CommandRegistry;
use App\Infrastructure\CQRS\SupportedCommandValidator;
use App\Modules\Order\Models\Order;
use App\Modules\Order\Repositories\Interfaces\OrderRepository;
use App\Modules\Order\Services\CQRS\Commands\DestroyOrderCommand;

final class DestroyOrderCommandHandler implements CommandHandler
{
    private OrderRepository $repository;

    public function __construct(OrderRepository $repository)
    {
        $this->repository = $repository;
    }

    public static function handles(): string
    {
        return DestroyOrderCommand::class;
    }

    /**
     * @param Command|DestroyOrderCommand $command
     * @param CommandRegistry $registry
     * @return string|null
     *
     * @todo while implementing rest of profiles CRUD trigger deleting here as well
     * @see Order::entry()
     */
    public function handle(Command $command, CommandRegistry $registry): ?int
    {
        (new SupportedCommandValidator($command, $this))();

        $this->repository
            ->delete($command->getOrder());

        return null;
    }
} 