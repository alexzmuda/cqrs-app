<?php

namespace App\Infrastructure\CQRS;

final class EagerQueryRegistry implements QueryRegistry
{
    /**
     * @var array|QueryHandler[]
     */
    private array $handlers = [];

    public function __construct(QueryHandler ...$handlers)
    {
        foreach ($handlers as $handler) {
            throw_if(
                array_key_exists($handler->handles(), $this->handlers),
                \Exception::class,
                sprintf(
                    'Another handler is registered for "%s" Query already.',
                    $handler->handles()
                )
            );

            $this->handlers[$handler->handles()] = $handler;
        }
    }

    public function handle(Query $query): object
    {
        $class = get_class($query);

        throw_unless(
            array_key_exists($class, $this->handlers),
            \Exception::class,
            sprintf('No handler registered for "%s" Query.', $class)
        );

        return $this->handlers[$class]->handle($query);
    }
}
