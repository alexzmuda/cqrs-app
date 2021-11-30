<?php

declare(strict_types=1);

namespace App\Infrastructure\CQRS;

use App\Exceptions\CommandHandlerRegistrationException;
use Illuminate\Contracts\Foundation\Application;
use Traversable;

final class LazyCommandRegistry implements CommandRegistry
{
    public const COMMAND_TAG = 'command_handler.lazy';

    private Application $application;

    /**
     * @var array<string, string>
     */
    private array $commandHandlersMap = [];

    public function __construct(Application $application)
    {
        $this->application = $application;

        /** @var Traversable<string> $rewindableGenerator */
        $rewindableGenerator = $application->tagged(self::COMMAND_TAG);
        array_map(
            function (string $commandHandlerClass) {
                if (!is_subclass_of($commandHandlerClass, CommandHandler::class)) {
                    throw CommandHandlerRegistrationException::unexpectedClass($commandHandlerClass);
                }

                $handledCommandClass = $commandHandlerClass::handles();

                if (array_key_exists($handledCommandClass, $this->commandHandlersMap)) {
                    throw CommandHandlerRegistrationException::commandHandledAlready($handledCommandClass);
                }

                $this->commandHandlersMap[$handledCommandClass] = $commandHandlerClass;
            },
            //$rewindableGenerator
            iterator_to_array($rewindableGenerator)
        );
    }

    public function handle(Command $command)
    {
        $commandClass = get_class($command);

        if (!array_key_exists($commandClass, $this->commandHandlersMap)) {
            throw CommandHandlerRegistrationException::missingHandler($commandClass);
        }

        /** @var CommandHandler $handler */
        $handler = $this->application
            ->make($this->commandHandlersMap[$commandClass]);

        return $handler->handle($command, $this);
    }
}
