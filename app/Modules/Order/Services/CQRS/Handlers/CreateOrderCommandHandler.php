<?php

declare(strict_types=1);

namespace App\Modules\Order\Services\CQRS\Handlers;

use App\Exceptions\CommandInvalidException;
use App\Exceptions\InvalidParameterException;
use App\Infrastructure\CQRS\Command;
use App\Infrastructure\CQRS\CommandHandler;
use App\Infrastructure\CQRS\CommandRegistry;
use App\Infrastructure\CQRS\SupportedCommandValidator;
use App\Modules\Order\Models\Order;
use App\Modules\Order\Repositories\Interfaces\OrderRepository;
use App\Modules\Order\Services\CQRS\Commands\CreateOrderCommand;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

final class CreateOrderCommandHandler implements CommandHandler
{
    private OrderRepository $repository;

    public function __construct(OrderRepository $repository)
    {
        $this->repository = $repository;
    }

    public static function handles(): string
    {
        return CreateOrderCommand::class;
    }

    /**
     * @param Command|CreateOrderCommand $command
     * @param CommandRegistry $registry
     * @return int|null
     * @throws CommandInvalidException
     * @throws InvalidParameterException
     */
    public function handle(Command $command, CommandRegistry $registry): ?int
    {
        (new SupportedCommandValidator($command, $this))();

        $entry = new Order([
            'firstname' => $command->orderFirstname()->getValue(),
            'lastname' => $command->orderLastname()->getValue(),
            'codes' => $command->orderCodes()->getValue(),
            'total_price' => $command->orderTotalPrice()->getValue(),
        ]);

        $this->repository->store($entry);

        return $entry->getKey();
    }
} 