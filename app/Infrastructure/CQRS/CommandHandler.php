<?php

declare(strict_types=1);

namespace App\Infrastructure\CQRS;

interface CommandHandler
{
    /**
     * @return string Classname of handled Commands
     *
     * @see Command
     */
    public static function handles(): string;

    /**
     * @param Command $command
     * @param CommandRegistry $registry
     * @return int|null Can return some ID - it's up to handler
     */
    public function handle(Command $command, CommandRegistry $registry): ?int;
}
