<?php

/**
 * Repositories are usually a common wrapper for model and the place where you would write different queries to
 * your database.
 */

namespace App\Modules\Order\Repositories\Interfaces;

use App\Modules\Order\Exceptions\OrderNotFoundException;
use App\Modules\Order\Models\Order;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

interface OrderRepository
{
    public function index(): Collection;

    public function store(Order $ingredient): void;

    /** @throws OrderNotFoundException */
    public function findById(int $ingredient): Order;

    public function delete(Order $ingredient): void;

}
