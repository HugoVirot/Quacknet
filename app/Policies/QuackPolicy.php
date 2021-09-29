<?php

namespace App\Policies;

use App\User;
use App\Quack;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class QuackPolicy
{
    use HandlesAuthorization;

    public function before(User $user)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }
    

    /**
     * Determine whether the user can create quacks.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create()
    {
        if (Auth::user())
        {
            return true;
        }
    }

    /**
     * Determine whether the user can update the quack.
     *
     * @param  \App\User  $user
     * @param  \App\Quack  $quack
     * @return mixed
     */

    public function update(User $user, Quack $quack)
    {
        return $user->id === $quack->user_id;
    }

    /**
     * Determine whether the user can delete the quack.
     *
     * @param  \App\User  $user
     * @param  \App\Quack  $quack
     * @return mixed
     */
    public function delete(User $user, Quack $quack)
    {
        if (($user->id === $quack->user_id)){
            return true;
        }
    }
}
