<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use App\Notifications\SuccessPayment;

class PageController extends Controller
{
    public function home()
    {
        $categories = Category::where('category_id', null)->get();
        return view('home', compact('categories'));
    }

    /**
     * Show all restaurant in a category
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     **/
    public function showCategoryRestaurant($id)
    {
        $category = Category::find($id);
        return view('customer.category.categoryIndex', compact('category'));
    }

    /**
     * Show all food in a restaurant
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     **/

    public function showRestaurantFood($id)
    {
        $restaurant = Restaurant::find($id);

        return view('customer.category.restaurant.restaurantIndex', compact('restaurant'));
    }

    /**
     * Show cart
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     **/

    public function carts($id)
    {
        return view('customer.cart.index_cart');
    }

    public function showPayment($id)
    {
        return view('customer.cart.payment', compact('id'));
    }

    public function handlePayment(Request $request)
    {
        if ($request->status == 'success') {
            $user = auth()->user();
            $cart = Cart::find($request->cart_id);
            $cart->update(['status' => "1"]);
            $user->notify(new SuccessPayment($cart));
        }
        else {

        }

        return redirect()->route('cart.show', auth()->id());
    }

}
