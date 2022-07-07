<?php

namespace App\Policies;

use App\Models\Cart;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class CartPolicy
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
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Cart $cart)
    {
        if ($user->id == $cart->user_id) {
            return Response::allow();
        }
        return Response::deny('You can\'t see carts');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        if (auth()->check()) {
            return Response::allow();
        }
        return Response::deny('you can\'t create cart');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Cart $cart)
    {
        if ($user->id == $cart->user_id) {
            return Response::allow();
        }
        return Response::deny('You can\'t update cart');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Cart $cart)
    {
    //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Cart $cart)
    {
    //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Cart $cart)
    {
    //
    }

    public function userCartByRestaurant(User $user, Cart $cart)
    {
        if ($user->id == $cart->user_id) {
            return Response::allow();
        }
        return Response::deny('you can\'t see cart');
    }
}
