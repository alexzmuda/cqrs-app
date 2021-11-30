<?php

declare(strict_types=1);

namespace App\Infrastructure\CQRS;

use App\Exceptions\CommandInvalidException;

final class SupportedCommandValidator
{
    private Command $command;
    private CommandHandler $handler;

    public function __construct(Command $command, CommandHandler $handler)
    {
        $this->command = $command;
        $this->handler = $handler;
    }

    public function __invoke(): void
    {
        $expectedClass = $this->handler->handles();
        $actualClass = get_class($this->command);

        if ($expectedClass !== $actualClass) {
            throw new CommandInvalidException($expectedClass, $actualClass);
        }
    }
}
