<?php

/**
 * Repositories are usually a common wrapper for model and the place where you would write different queries to
 * your database.
 */

namespace App\Modules\Product\Repositories\Interfaces;

use App\Modules\Product\Exceptions\ProductNotFoundException;
use App\Modules\Product\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

interface ProductRepository
{
    public function index(): Collection;

    public function store(Product $product): void;

    /** @throws ProductNotFoundException */
    public function findById(int $productId): Product;

    /** @throws ProductNotFoundException */
    public function findByCode(string $productCode): Product;

    public function delete(Product $product): void;

}
