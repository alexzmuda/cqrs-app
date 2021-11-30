<?php

declare(strict_types=1);

namespace App\Infrastructure\CQRS;

use Illuminate\Contracts\Foundation\Application;

class RegisterCommandHandler
{
    private Application $application;

    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    public function __invoke(string $className): void
    {
        if (!is_subclass_of($className, CommandHandler::class)) {
            throw new \Exception('Expected class implementing CommandHandler, got ' . $className);
        }

        $serviceName = $className . '.class';
        $this->application->singleton($serviceName, static fn () => $className);
        $this->application->tag($serviceName, [LazyCommandRegistry::COMMAND_TAG]);
    }
}
