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
     * @param  AddCommentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddCommentRequest $request)
    {
        $cart = Cart::find($request->cart_id);
        if ($cart->user_id != auth()->id()) {
            return response(['msg' => 'You can not add comment to this cart'], 403);
        } //TODO:add policy to check if user can add comment to this cart 

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
            return CommentRestaurantResource::collection($restaurant->carts->map(fn($cart) => $cart->comments->sortBy('created_at'))->flatten());
        }) ?? ['msg' => 'restaurant not found'];

        return $comments;
    }

    public function findCommentsForAdmin()
    {
        $comments = CommentAdminResource::collection(Comment::where('delete_request', true)->get());

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
                )
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
        // TODO:add policy
        if ($comment) {
            $comment->delete();
            return response(['msg' => 'Delete request updated successfully']);
        }
        else {
            return response(['msg' => 'comment not found'], 402);
        }
    }

    public function setAnswer(Request $request)
    {
        $comment = Comment::find($request->comment_id);
        // TODO:add policy

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
        // TODO:add policy
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
