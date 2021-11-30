<?php

namespace App\Infrastructure\CQRS;

use Illuminate\Database\Eloquent\Model;

interface QueryRegistry
{
    /**
     * @param Query $query
     * @return object|Model result of QueryHandler execution
     * @see QueryHandler::handle()
     */
    public function handle(Query $query): object;
}
