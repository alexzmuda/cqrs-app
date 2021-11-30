<?php

namespace App\Modules\Product\Policies;

use App\Modules\User\Models\User;
use App\Modules\Product\Models\Product;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ProductPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the entry.
     * @param \App\Modules\User\Models\User $user
     * @param \App\Modules\Product\Models\Product $model
     * @return mixed
     */
    public function viewProduct(User $user, Product $model)
    {
        // can't view if model doesn't belong to user or any other logic
        return true;
    }

    /**
     * Determine whether the user can delete the entry.
     *
     * @param \App\Modules\User\Models\User $user
     * @param \App\Modules\Product\Models\Product $model
     * @return mixed
     */
    public function deleteProduct(User $user, Product $model)
    {
        // only admin can delete
        return ($user->getKey() === 1) // hardcoded id of admin
            ? Response::allow()
            : Response::deny('Only admin can delete products');
    }
} 