<?php

namespace App\Modules\Order\Services\CQRS\Handlers;

use App\Exceptions\QueryInvalidException;
use App\Infrastructure\CQRS\Query;
use App\Infrastructure\CQRS\QueryHandler;
use App\Infrastructure\CQRS\SupportedQueryValidator;
use App\Modules\Order\Exceptions\OrderNotFoundException;
use App\Modules\Order\Repositories\Interfaces\OrderRepository;
use App\Modules\Order\Services\CQRS\Queries\FetchOrderByIdQuery;


class FetchOrderByIdQueryHandler implements QueryHandler
{
    private OrderRepository $repository;

    public function __construct(OrderRepository $repository)
    {
        $this->repository = $repository;
    }

    public static function handles(): string
    {
        return FetchOrderByIdQuery::class;
    }

    /**
     * @param Query|FetchOrderByIdQuery $query
     * @return object
     * @throws QueryInvalidException|OrderNotFoundException
     */
    public function handle(Query $query): object
    {
        (new SupportedQueryValidator($query, $this))();

        return $this->repository
            ->findById($query->getOrderId());
    }
} 