<?php

namespace App\Observers;

use Carbon\Carbon;
use App\Models\FoodParty;
use App\Jobs\EndFoodPartyJob;
use App\Jobs\StartFoodPartyJob;

class FoodPartyObserver
{
    /**
     * Handle the FoodParty "created" event.
     *
     * @param  \App\Models\FoodParty  $foodParty
     * @return void
     */
    public function created(FoodParty $foodParty)
    {
        StartFoodPartyJob::dispatch($foodParty)->delay(Carbon::parse($foodParty->start_at));
        EndFoodPartyJob::dispatch($foodParty)->delay(Carbon::parse($foodParty->expires_at));
    }

    /**
     * Handle the FoodParty "updated" event.
     *
     * @param  \App\Models\FoodParty  $foodParty
     * @return void
     */
    public function updating(FoodParty $foodParty)
    {
        if ($foodParty->isDirty('start_at')) {
            StartFoodPartyJob::dispatch($foodParty)->delay(Carbon::parse($foodParty->start_at));
        }
        if ($foodParty->isDirty('expires_at')) {
            EndFoodPartyJob::dispatch($foodParty)->delay(Carbon::parse($foodParty->expires_at));
        }
    }

    /**
     * Handle the FoodParty "deleted" event.
     *
     * @param  \App\Models\FoodParty  $foodParty
     * @return void
     */
    public function deleted(FoodParty $foodParty)
    {
    //
    }

    /**
     * Handle the FoodParty "restored" event.
     *
     * @param  \App\Models\FoodParty  $foodParty
     * @return void
     */
    public function restored(FoodParty $foodParty)
    {
    //
    }

    /**
     * Handle the FoodParty "force deleted" event.
     *
     * @param  \App\Models\FoodParty  $foodParty
     * @return void
     */
    public function forceDeleted(FoodParty $foodParty)
    {
    //
    }
}
