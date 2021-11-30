<?php

declare(strict_types=1);

namespace App\Infrastructure\CQRS;

use App\Exceptions\QueryInvalidException;

final class SupportedQueryValidator
{
    private Query $query;
    private QueryHandler $handler;

    public function __construct(Query $query, QueryHandler $handler)
    {
        $this->query = $query;
        $this->handler = $handler;
    }

    /**
     * @throws QueryInvalidException
     */
    public function __invoke(): void
    {
        $expectedQuery = $this->handler->handles();
        $receivedQuery = get_class($this->query);

        if ($expectedQuery !== $receivedQuery) {
            throw new QueryInvalidException(
                $expectedQuery,
                $receivedQuery
            );
        }
    }
}
