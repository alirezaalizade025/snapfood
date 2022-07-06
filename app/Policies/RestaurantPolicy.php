<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Restaurant;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class RestaurantPolicy
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
        if ($user->role == 'admin') {
            return Response::allow();
        }
        return Response::deny('You can\'t view restaurants');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Restaurant $restaurant)
    {
        if (($user->role == 'restaurant' && $user->id == $restaurant->user_id) || is_null($restaurant)) {
            return Response::allow();
        }
        return Response::deny('You can\'t view restaurant');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        if ($user->role == 'restaurant') {
            return Response::allow();
        }
        return Response::deny('You can\'t create restaurant');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Restaurant $restaurant)
    {
        if ($user->role == 'restaurant' && $user->id == $restaurant->user_id) {
            return Response::allow();
        }
        return Response::deny('You can\'t update restaurant');
    }

    /**
     * Determine whether the user can see/update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function order(User $user, Restaurant $restaurant)
    {
        if ($user->role == 'admin' || ($user->role == 'restaurant' && $user->id == $restaurant->user_id)) {
            return Response::allow();
        }
        return Response::deny('You can\'t see orders');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Restaurant $restaurant)
    {
    //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Restaurant $restaurant)
    {
    //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Restaurant $restaurant)
    {
    //
    }

    public function changeConfirm(User $user)
    {
        if ($user->role == 'admin') {
            return Response::allow();
        }
        return Response::deny('Just Admin can change restaurant confirm');
    }

    public function changeStatus(User $user, Restaurant $restaurant)
    {
        if ($user->role == 'restaurant' && $user->id == $restaurant->user_id) {
            return Response::allow();
        }
        return Response::deny('Just restaurant owner can change restaurant status');
    }
}
