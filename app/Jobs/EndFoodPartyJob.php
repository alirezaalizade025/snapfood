<?php

namespace App\Jobs;

use Carbon\Carbon;
use App\Models\FoodParty;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class EndFoodPartyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $foodParty;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(FoodParty $foodParty)
    {
        $this->foodParty = $foodParty;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if($this->foodParty->status == 'inactive' || !Carbon::parse($this->foodParty->expires_at)->isPast()) {
            return;
        }

        $this->foodParty->end();
        $this->foodParty->save();
    }
}
