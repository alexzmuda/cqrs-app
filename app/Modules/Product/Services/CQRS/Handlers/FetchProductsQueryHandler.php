<?php

namespace App\Modules\Product\Services\CQRS\Handlers;

use App\Exceptions\QueryInvalidException;
use App\Infrastructure\CQRS\Query;
use App\Infrastructure\CQRS\QueryHandler;
use App\Infrastructure\CQRS\SupportedQueryValidator;
use App\Modules\Product\Repositories\Interfaces\ProductRepository;
use App\Modules\Product\Services\CQRS\Queries\FetchProductsQuery;


class FetchProductsQueryHandler implements QueryHandler
{
    private ProductRepository $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    public static function handles(): string
    {
        return FetchProductsQuery::class;
    }

    /**
     * @param Query|FetchProductsQuery $query
     * @return object
     */
    public function handle(Query $query): object
    {
        (new SupportedQueryValidator($query, $this))();

        return $this->repository
            ->index();
    }
} 