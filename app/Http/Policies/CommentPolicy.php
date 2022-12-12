<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;

class CommentPolicy
{
    use HandlesAuthorization;

    public function before(User $user)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    /**
     * Determine whether the user can create comments.
     *
     * @param  \app\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        // = return Auth::user();
        if (Auth::user())
        {
            return true;
        }
    }

    /**
     * Determine whether the user can update the comment.
     *
     * @param  \app\Models\User  $user
     * @param  \App\Models\Comment  $comment
     * @return mixed
     */
    public function update(User $user, Comment $comment)
    {
        return $user->id === $comment->user_id;
    }

    /**
     * Determine whether the user can delete the comment.
     *
     * @param  \app\Models\User  $user
     * @param  \App\Models\Comment  $comment
     * @return mixed
     */
    public function delete(User $user, Comment $comment)
    {
        if ($user->id === $comment->user_id || $user->id === $comment->quack->user_id){
            return true;
        }
    }
}
