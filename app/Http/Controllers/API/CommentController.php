<?php

namespace App\Http\Controllers\API;

use App\Models\Cart;
use App\Models\Food;
use App\Models\Comment;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddCommentRequest;
use App\Http\Resources\CommentFoodResource;
use App\Http\Resources\CommentRestaurantResource;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\AddCommentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddCommentRequest $request)
    {
        $cart = Cart::find($request->cart_id);
        if ($cart->user_id != auth()->id()) {
            return response(['msg' => 'You can not add comment to this cart'], 403);
        }

        if ($cart->comments()->create(['user_id' => auth()->id(),'score' => $request->score, 'content' => $request->message])) {
            return response (['msg' => 'comment created successfully'], 200);
        }

        return response($cart);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        if (isset($request->restaurant_id)) {
            $comments = $this->findCommentsByRestaurant($request->restaurant_id);
        }
        elseif (isset($request->food_id)) {
            $comments = $this->findCommentsByFood($request->food_id);
        }
        else {
            return response(['msg' => 'set (restaurant / food)\'s id'], 404);
        }

        return response(compact('comments'));
    }

    public function findCommentsByRestaurant(int $id)
    {
        $comments = optional(Restaurant::find($id), function ($restaurant) {
            return CommentRestaurantResource::collection($restaurant->carts->map(fn($cart) => $cart->comments)->flatten());
        }) ?? ['msg' => 'restaurant not found'];

        return $comments;
    }

    public function findCommentsByFood(int $id)
    {

        $comments = optional(Food::find($id), function ($food) use ($id) {
            return $food->cartFood
            ->map(function ($food) {
                    return CommentFoodResource::collection($food->cart->comments)->first();
                }
                )
                ;
            }) ?? ['msg' => 'food not found'];
        $tt = $comments;
        return $tt;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
    //
    }
}
