<?php

declare(strict_types=1);

namespace App\Infrastructure\CQRS;

final class EagerCommandRegistry implements CommandRegistry
{
    /** @var CommandHandler[] */
    private array $handlers = [];

    public function __construct(CommandHandler ...$handlers)
    {
        foreach ($handlers as $handler) {
            throw_if(
                array_key_exists($handler->handles(), $this->handlers),
                \Exception::class,
                sprintf(
                    'Another handler is registered for "%s" Command already.',
                    $handler->handles()
                )
            );

            $this->handlers[$handler->handles()] = $handler;
        }
    }

    public function handle(Command $command): ?int
    {
        $class = get_class($command);

        throw_unless(
            array_key_exists($class, $this->handlers),
            \Exception::class,
            sprintf('No handler registered for "%s" Command.', $class)
        );

        return $this->handlers[$class]->handle($command, $this);
    }
}
