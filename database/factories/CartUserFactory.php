<?php

namespace Database\Factories;

use App\Models\Cart;
use App\Models\Food;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CartUser>
 */
class CartUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'cart_id' => $this->faker->randomElement(Cart::pluck('id')->toArray()),
            'food_id' => $this->faker->randomElement(Food::pluck('id')->toArray()),
            'quantity' => $this->faker->numberBetween(1, 10),
            'price' => $this->faker->randomFloat(2, 0, 100000),
        ];
    }
}
