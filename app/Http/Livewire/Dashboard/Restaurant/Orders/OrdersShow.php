<?php

namespace App\Http\Livewire\Dashboard\Restaurant\Orders;

use App\Models\Cart;
use Livewire\Component;
use App\Jobs\SendMailJob;
use App\Jobs\DeliveryDelay;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Http;
use App\Notifications\DeliveredNotification;
use App\Notifications\PreparingNotification;
use App\Notifications\DeliveringNotification;

class OrdersShow extends Component
{
    use WithPagination;
    public $restaurant;
    public $search;
    public $status = ['1'];
    public $emailClasses = [
        PreparingNotification::class ,
        DeliveringNotification::class ,
        DeliveredNotification::class ,
    ];
    protected $listeners = [
        'refreshComponent' => '$refresh',
    ];

    public function changeStatus($cartId, $status)
    {
        $cart = Cart::find($cartId);
        if ($cart->status != 4) {
            $cart->status = "$status";
            $cart->update();

            $this->sendMail($status, $cart);

            if ($status == 3) {
                dispatch(new DeliveryDelay($cart))->delay(now()->addSeconds(20)); //TODO: change to 1 hour
            }
            $this->emitSelf('refreshComponent');
        }
    }

    public function sendMail($status, $cart)
    {
        $user = auth()->user();
        if ($status == 2) {
            $mail = new PreparingNotification($cart);
            dispatch(new SendMailJob($user, $mail));
        }
        elseif ($status == 3) {
            $mail = new DeliveringNotification($cart);
            dispatch(new SendMailJob($user, $mail));

        }
        elseif ($status == 4) {
            $mail = new DeliveredNotification($cart);
            dispatch(new SendMailJob($user, $mail));
        }
    }

    public function filterStatus($status_id)
    {
        if (in_array($status_id, $this->status)) {
            unset($this->status[array_search($status_id, $this->status)]);
        }
        else {
            $this->status[] = $status_id;
        }
    }

    public function fetchData()
    {
        $where = [];
        if ($this->search != null) {
            $where[] = ['id', $this->search];
        }
        $this->carts = Cart::where('restaurant_id', $this->restaurant->id)
            ->whereIn('status', $this->status)
            ->where($where)
            ->orderBy('status')
            ->orderBy('updated_at')
            ->get()
            ->map(function ($cart) {
            $cart->food = $cart->cartFood->each(function ($cart) {
                    $cart->final_price = $cart->price * $cart->quantity;
                }
                );
                $cart->final_price = $cart->food->sum('final_price');
                return $cart;
            })->filter(function ($cart) {
            return $cart->food->count() > 0;
        });

    }

    public function render()
    {
        $this->fetchData();
        return view('livewire.dashboard.restaurant.orders.orders-show');
    }
}
