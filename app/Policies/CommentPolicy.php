<?php

namespace App\Policies;

use App\Models\Cart;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Comment $comment)
    {
        if ($user->role === 'admin') {
            return Response::allow();
        }
        return Response::deny('You are not authorized to view this comment');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user, $cart)
    {
        if ($user->role == 'customer' && $cart->user_id == $user->id && $cart->status != '0' && $cart->comments->count() < 1) {
            return Response::allow();
        }
        return Response::deny('You are not allowed to create comments');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Comment $comment)
    {
        if ($user->role == 'restaurant' && $comment->cart->restaurant_id == $user->restaurant->id) {
            return Response::allow();
        }
        return Response::deny('You are not authorized to update this comment');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Comment $comment)
    {
        if ($user->role == 'admin') {
            return Response::allow();
        }
        return Response::deny('You are not authorized to delete this comment');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Comment $comment)
    {
    //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Comment $comment)
    {
    //
    }

}
