<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Jobs\SendMailJob;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use App\Notifications\SuccessPayment;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class PageController extends Controller
{
    public function dashboard()
    {
        if (auth()->user()->role == 'admin') {
            $carts = [
                'chart_title' => 'Carts',
                'chart_type' => 'line',
                'report_type' => 'group_by_date',
                'model' => 'App\Models\Cart',
                'group_by_field' => 'created_at',
                'group_by_period' => 'day',
                'aggregate_function' => 'count',
                'filter_field' => 'created_at',
                'filter_days' => '30',
                'group_by_field_format' => 'Y-m-d H:i:s',
                'column_class' => 'col-md-12',
                'entries_number' => '5',
                'translation_key' => 'cart',
                'continuous_time' => true,
            ];
            $users = [
                'chart_title' => 'Users',
                'chart_type' => 'line',
                'report_type' => 'group_by_date',
                'model' => 'App\Models\User',
                'group_by_field' => 'created_at',
                'group_by_period' => 'day',
                'aggregate_function' => 'count',
                'filter_field' => 'created_at',
                'filter_days' => '30',
                'group_by_field_format' => 'Y-m-d H:i:s',
                'column_class' => 'col-md-12',
                'entries_number' => '5',
                'translation_key' => 'cart',
                'continuous_time' => true,
            ];
            $restaurants = [
                'chart_title' => 'Restaurants',
                'chart_type' => 'line',
                'report_type' => 'group_by_date',
                'model' => 'App\Models\Restaurant',
                'group_by_field' => 'created_at',
                'group_by_period' => 'day',
                'aggregate_function' => 'count',
                'filter_field' => 'created_at',
                'filter_days' => '30',
                'group_by_field_format' => 'Y-m-d H:i:s',
                'column_class' => 'col-md-12',
                'entries_number' => '5',
                'translation_key' => 'cart',
                'continuous_time' => true,
            ];
            $comments = [
                'chart_title' => 'Comments',
                'chart_type' => 'line',
                'report_type' => 'group_by_date',
                'model' => 'App\Models\Restaurant',
                'group_by_field' => 'created_at',
                'group_by_period' => 'day',
                'aggregate_function' => 'count',
                'filter_field' => 'created_at',
                'filter_days' => '30',
                'group_by_field_format' => 'Y-m-d H:i:s',
                'column_class' => 'col-md-12',
                'entries_number' => '5',
                'translation_key' => 'cart',
                'continuous_time' => true,
            ];

            $usersChart = new LaravelChart($users);
            $restaurantsChart = new LaravelChart($restaurants);
            $cartsChart = new LaravelChart($carts);
            $commentsChart = new LaravelChart($comments);
            return view('dashboard', compact('cartsChart', 'usersChart', 'restaurantsChart', 'commentsChart'));
        }
        elseif (auth()->user()->role == 'restaurant') {
            $totalFood = auth()->user()->restaurant->foods->count();
            $totalCarts = auth()->user()->restaurant->carts->count();
            $totalComments = auth()->user()->restaurant->carts->map(function ($cart) {
                return $cart->comments->count();
            })->sum();

            return view('dashboard', compact('totalFood', 'totalCarts', 'totalComments'));

        }

    }
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
        $restaurant = Cart::find($id)->restaurant;

        //check for open time
        if ($restaurant->weekSchedules->count() > 0) {
            $weekSchedules = $restaurant->weekSchedules()->where('day', now()->dayOfWeek - 5)->get()->first();
            if (now()->format('H:i') >= $weekSchedules->open_time && now()->format('H:i') <= $weekSchedules->close_time) {
                if ($restaurant->status == 'inactive') {
                    return redirect()->back()->withErrors(['error' => 'Sorry, we are closed now']);
                }
            }
            else {
                return redirect()->back()->withErrors(['error' => 'Sorry, we are closed now']);
                ;
            }
        }
        else {
            return back()->withErrors(['error' => 'Sorry, we are closed now']);
        }

        return view('customer.cart.payment', compact('id'));
    }

    public function handlePayment(Request $request)
    {
        if ($request->status == 'success') {
            $cart = Cart::find($request->cart_id);
            $cart->update(['status' => "1"]);

            $user = auth()->user();
            $mail = new SuccessPayment($cart);
            dispatch(new SendMailJob($user, $mail));
        }

        return redirect()->route('cart.show', auth()->id());
    }

}
