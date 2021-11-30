<?php

declare(strict_types=1);

namespace App\Infrastructure\CQRS;

use App\Exceptions\QueryHandlerRegistrationException;
use Illuminate\Container\RewindableGenerator;
use Illuminate\Foundation\Application;
use Traversable;

final class LazyQueryRegistry implements QueryRegistry
{
    public const QUERY_TAG = 'query_handler.lazy';

    private Application $application;

    /**
     * @var array<string, string>
     */
    private array $queryHandlersMap = [];

    public function __construct(Application $application)
    {
        $this->application = $application;

        /** @var Traversable<string> $rewindableGenerator */
        $rewindableGenerator = $application->tagged(self::QUERY_TAG);

        array_map(
            function (string $queryHandlerClass) {
                if (!is_subclass_of($queryHandlerClass, QueryHandler::class)) {
                    throw QueryHandlerRegistrationException::unexpectedClass((string) $queryHandlerClass);
                }

                $handledQueryClass = $queryHandlerClass::handles();

                if (array_key_exists($handledQueryClass, $this->queryHandlersMap)) {
                    throw QueryHandlerRegistrationException::queryHandledAlready($handledQueryClass);
                }

                $this->queryHandlersMap[$handledQueryClass] = $queryHandlerClass;
            },
            iterator_to_array(
                $rewindableGenerator
            )
        );
    }

    public function handle(Query $query): object
    {
        $queryClass = get_class($query);

        if (!array_key_exists($queryClass, $this->queryHandlersMap)) {
            throw QueryHandlerRegistrationException::missingHandler($queryClass);
        }

        /** @var QueryHandler $handler */
        $handler = $this->application
            ->make($this->queryHandlersMap[$queryClass]);

        return $handler->handle($query);
    }
}
