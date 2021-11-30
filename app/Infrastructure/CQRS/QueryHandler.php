<?php

namespace App\Infrastructure\CQRS;

use App\Exceptions\QueryInvalidException;
use Illuminate\Database\Eloquent\Model;

interface QueryHandler
{
    /**
     * @return string
     * ::class of Query related to given handler
     *
     * @see Query
     */
    public static function handles(): string;

    /**
     * @param Query $query
     * @return object|Model either full eloquent object or in special cases
     * a DTO representing set of data uncontainable by a single entity.
     * @throws QueryInvalidException
     */
    public function handle(Query $query): object;
}
