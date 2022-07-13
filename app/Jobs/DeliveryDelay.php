<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Notifications\DeliveryDelayNotification;

class DeliveryDelay implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $cart;
    public $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($cart)
    {
        $this->cart = $cart;
        $this->user = $cart->user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->user->notify(new DeliveryDelayNotification($this->cart));
    }
}
