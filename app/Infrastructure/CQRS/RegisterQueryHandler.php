<?php

declare(strict_types=1);

namespace App\Infrastructure\CQRS;

use Illuminate\Contracts\Foundation\Application;

class RegisterQueryHandler
{
    private Application $application;

    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    public function __invoke(string $className): void
    {
        if (!is_subclass_of($className, QueryHandler::class)) {
            throw new \Exception('Expected class implementing QueryHandler, got ' . $className);
        }

        $serviceName = $className . '.class';
        $this->application->singleton($serviceName, static fn () => $className);
        $this->application->tag($serviceName, [LazyQueryRegistry::QUERY_TAG]);
    }
}
