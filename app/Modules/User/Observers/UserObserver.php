<?php


namespace App\Modules\User\Observers;


use App\Modules\User\Models\User;
use Ramsey\Uuid\Uuid;

class UserObserver
{

    public function creating(User $user)
    {
        $user->uuid = Uuid::uuid4();
    }

}
