<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    public function creating(User $user)
    {
        if (! \App::runningInConsole()) {

            $user->assignRole('user');
        }
    }
}
