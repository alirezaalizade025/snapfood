<?php

namespace App\Http\Livewire\Customer\Comment;

use App\Models\Cart;
use App\Models\Food;
use Livewire\Component;
use WireUi\Traits\Actions;
use Illuminate\Http\Request;
use App\Http\Controllers\API\CommentController;

class FoodModal extends Component
{
    use Actions;
    public $showingModal = false;
    public $food;
    public $title;
    public $comments = [];
    public $score;
    public $food_id;
    public $uncommentedCarts;

    public $listeners = [
        'hideMe' => 'hideModal',
        'showFoodModal' => 'showModal'
    ];

    public function hideModal()
    {
        $this->showingModal = false;
    }


    public function showModal($food_id)
    {
        $this->food_id = $food_id;
        $this->showingModal = true;
        $this->resetErrorBag();
    }

    public function fetchData()
    {
        $food_id = $this->food_id;
        $request = new Request(['food_id' => $food_id]);
        $response = app(CommentController::class)->show($request);
        if ($response->status() == 200) {
            $comments = collect(json_decode($response->getContent())->comments);
        }

        $this->food = Food::find($food_id);
        if ($this->food->food_party_id != null) {
            $this->food->off = [
                'label' => $this->food->foodParty->discount . '%',
                'factor' => 1 - $this->food->foodParty->discount / 100
            ];
        }
        elseif ($this->food->discount != null) {
            $this->food->off = [
                'label' => $this->food->discount . '%',
                'factor' => 1 - $this->food->discount / 100
            ];
        }

        $this->food->final_price = $this->food->price * ($this->food->off['factor'] ?? 1);
        $this->score = $comments->avg('score');
        $this->comments = $comments;

        $this->uncommentedCarts = Cart::has('comments', '<', 1)
            ->where('user_id', auth()->id())
            ->where('status', '4')
            ->get()
            ->filter(function ($cart) {
            return $cart->cartFood->contains('food_id', $this->food_id);
        });
    }


    public function render()
    {
        if ($this->showingModal) {
            $this->fetchData();
        }
        return view('livewire.customer.comment.food-modal');
    }


}
