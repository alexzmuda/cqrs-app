<?php

declare(strict_types=1);

namespace App\Infrastructure\CQRS;

interface CommandRegistry
{
    /**
     * @param Command $command
     * @return int|null Can return some ID - it's up to handler
     */
    public function handle(Command $command);
}
