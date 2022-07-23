<?php

namespace App\Http\Controllers\API;

use App\Models\Cart;
use App\Models\Food;
use App\Models\Comment;
use App\Models\CartFood;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddCommentRequest;
use App\Http\Resources\CommentFoodResource;
use App\Http\Resources\CommentAdminResource;
use App\Http\Resources\CommentRestaurantResource;

class CommentController extends Controller
{


    /**
     * Store a newly created resource in storage.
     *
     * @param  AddCommentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddCommentRequest $request)
    {
        try {
            $cart = Cart::findOrFail($request->cart_id);
        }
        catch (\Exception $e) {
            return response(['msg' => 'Cart not found'], 404);
        }

        $this->authorize('create', [Comment::class , $cart]);

        if ($cart->comments()->create(['user_id' => auth()->id(), 'score' => $request->score, 'content' => $request->message])) {
            return response(['msg' => 'comment created successfully'], 200);
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
            $comments = $this->findCommentsByRestaurant($request);
        }
        elseif (isset($request->food_id)) {
            $comments = $this->findCommentsByFood($request->food_id);
        }
        else {
            return response(['msg' => 'set (restaurant / food)\'s id'], 404);
        }

        return response(compact('comments'));
    }

    public function findCommentsByRestaurant($request)
    {
        $id = $request->restaurant_id;
        $food_id = $request->food_id;
        $comments = optional(Restaurant::find($id), function ($restaurant) use ($food_id) {
            return CommentRestaurantResource::collection($restaurant->carts
            ->filter(function ($cart) use ($food_id) {
                    if ($food_id == null) {
                        return true;
                    }
                    return $cart->foods->contains('id', $food_id);
                }
                )
                ->map(fn($cart) => $cart->comments)->flatten()->sortByDesc('created_at'));
            }) ?? ['msg' => 'restaurant not found'];
        return $comments;
    }

    public function findCommentsForAdmin()
    {
        $comments = Comment::where('delete_request', true)->get();
        if ($comments->count() > 0) {
            $this->authorize('view', $comments->first());
        }
        $comments = CommentAdminResource::collection($comments);

        return response($comments);
    }

    public function findCommentsByFood(int $id)
    {

        $comments = optional(Food::find($id), function ($food) use ($id) {
            return $food->cartFood
            ->map(function ($food) {
                    return CommentFoodResource::collection($food->cart->comments)->first();
                }
                )
                ->filter(function ($comment) {
                    return $comment != null;
                }
                )->flatten()
                ;
            }) ?? ['msg' => 'food not found'];
        return $comments;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $comment = Comment::find($request->comment_id);
        $this->authorize('delete', $comment);
        if ($comment) {
            $comment->delete();
            return response(['msg' => 'Delete requested successfully']);
        }
        else {
            return response(['msg' => 'comment not found'], 402);
        }
    }

    public function setAnswer(Request $request)
    {
        $comment = Comment::find($request->comment_id);
        $this->authorize('update', $comment);

        $request->validate([
            'answer' => 'required|string|max:255',
        ]);

        $comment->answer = trim($request->answer);
        $comment->save();

        return response(['msg' => 'answer set successfully']);

    }

    public function deleteRequest(Request $request)
    {
        $comment = Comment::find($request->comment_id);
        $this->authorize('update', $comment);
        if ($comment) {
            $comment->delete_request = $comment->delete_request == true ? false : true;
            $comment->save();
            return response(['msg' => 'Delete request updated successfully']);
        }
        else {
            return response(['msg' => 'comment not found'], 402);
        }

    }
}
