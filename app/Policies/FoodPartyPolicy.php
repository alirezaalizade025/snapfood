<?php

namespace App\Policies;

use App\Models\User;
use App\Models\FoodParty;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class FoodPartyPolicy
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
        return Response::deny('You can\'t see this page');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\FoodParty  $foodParty
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, FoodParty $foodParty)
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
        if ($user->role == 'admin') {
            return Response::allow();
        }
        return Response::deny('You can\'t create food party');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\FoodParty  $foodParty
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user)
    {
        if ($user->role == 'admin') {
            return Response::allow();
        }
        return Response::deny('You can\'t update food party');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\FoodParty  $foodParty
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user)
    {
        if ($user->role == 'admin') {
            return Response::allow();
        }
        return Response::deny('You can\'t delete food party');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\FoodParty  $foodParty
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, FoodParty $foodParty)
    {
    //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\FoodParty  $foodParty
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, FoodParty $foodParty)
    {
    //
    }
}
