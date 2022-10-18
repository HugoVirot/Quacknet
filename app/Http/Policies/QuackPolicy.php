<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Quack;
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
     * @param  \app\Models\User  $user
     * @return mixed
     */
    public function create()
    {
        return Auth::user();
    }

    /**
     * Determine whether the user can update the quack.
     *
     * @param  \app\Models\User  $user
     * @param  \app\Models\Quack  $quack
     * @return mixed
     */

    public function update(User $user, Quack $quack)
    {
        // on vérifie si le user connecté a le droit de modifier le message
        // modification limitée à l'auteur

        if ($user->id == $quack->user_id){
            return true;
        } else {
            return false;
        }

        //return $user->id == $quack->user_id;
    }

    /**
     * Determine whether the user can delete the quack.
     *
     * @param  \app\Models\User  $user
     * @param  \app\Models\Quack  $quack
     * @return mixed
     */
    public function delete(User $user, Quack $quack)
    {
        return $user->id === $quack->user_id;
    }
}
