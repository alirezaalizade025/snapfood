<?php

namespace App\Http\Requests;

use App\Models\Cart;
use Illuminate\Foundation\Http\FormRequest;

class AddCommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $cart_id = $this->input('cart_id');

        $cart = Cart::find($cart_id);

        if ($cart && ($cart->user_id != auth()->id())) {
            return false;
        }

        return true;

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'cart_id' => 'required|exists:carts,id',
            'score' => 'required|integer|between:1,5',
            'message' => 'required|string|max:255',
        ];
    }
}
