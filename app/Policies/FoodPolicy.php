<?php

namespace App\Policies;

use App\Models\Food;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class FoodPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
    //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Food  $food
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Food $food)
    {
    //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        if (auth()->check() && auth()->user()->role == 'restaurant' && auth()->user()->restaurant->confirm == 'accept') {
            return Response::allow();
        }

        return Response::deny('You must be logged in to create food.');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Food  $food
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Food $food)
    {
        if ($user->id == $food->restaurant->user_id || $user->role == 'admin') {
            return Response::allow();
        }
        return Response::deny('You are not authorized to update this food.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Food  $food
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Food $food)
    {
        if ($user->id == $food->restaurant->user_id) {
            return Response::allow();
        }
        return Response::deny('You are not authorized to delete this food.');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Food  $food
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Food $food)
    {
    //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Food  $food
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Food $food)
    {
    //
    }
}
