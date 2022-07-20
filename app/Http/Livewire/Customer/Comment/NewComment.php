<?php

namespace App\Http\Livewire\Customer\Comment;

use App\Models\Cart;
use Livewire\Component;
use WireUi\Traits\Actions;
use Illuminate\Http\Request;
use App\Http\Requests\AddCommentRequest;
use App\Http\Controllers\API\CommentController;

class NewComment extends Component
{
    use Actions;
    public $newComment;
    public $newRating;
    public $uncommentedCarts;
    public $cart;
    public $food_id;


    public function updated($propertyName)
    {
        return $this->validateOnly($propertyName, [
            'newComment' => 'required|min:3|max:255',
            'newRating' => 'required|numeric|min:1|max:5',
            'cart' => 'required|exists:carts,id'
        ]);
    }

    public function addComment()
    {
        $request = new AddCommentRequest([
            'cart_id' => $this->cart,
            'message' => $this->newComment,
            'score' => $this->newRating
        ]);

        $response = app(CommentController::class)->store($request);
        if ($response->status() == 200) {
            $this->notification()->send([
                'title' => 'Comments Added!',
                'description' => json_decode($response->getContent())->msg,
                'icon' => 'success'
            ]);
            $this->emit('refreshFoodModal');
            $this->reset();
        }
        else {
            $this->notification()->send([
                'title' => 'Error in adding comment!',
                'description' => json_decode($response->getContent())->msg,
                'icon' => 'error'
            ]);
        }

    }

    public function fetchData()
    {
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
        $this->fetchData();
        return view('livewire.customer.comment.new-comment');
    }
}
