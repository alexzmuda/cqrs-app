<?php

namespace App\Modules\Order\Policies;

use App\Modules\User\Models\User;
use App\Modules\Order\Models\Order;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class OrderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the entry.
     * @param \App\Modules\User\Models\User $user
     * @param \App\Modules\Order\Models\Order $model
     * @return mixed
     */
    public function viewOrder(User $user, Order $model)
    {
        // can't view if model doesn't belong to user or any other logic
        return true;
    }

    /**
     * Determine whether the user can delete the entry.
     *
     * @param \App\Modules\User\Models\User $user
     * @param \App\Modules\Order\Models\Order $model
     * @return mixed
     */
    public function deleteOrder(User $user, Order $model)
    {
        // can't delete if model doesn't belong to user or any other logic
        return true;
    }
} 