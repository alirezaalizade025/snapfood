<?php

namespace Database\Factories;

use App\Models\Cart;
use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CartRestaurant>
 */
class CartRestaurantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'restaurant_id' => Restaurant::all()->random()->id,
            'cart_id' => Cart::all()->unique()->random()->id,
        ];
    }
}
