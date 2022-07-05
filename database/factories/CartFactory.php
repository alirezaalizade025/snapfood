<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cart>
 */
class CartFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->unique()->randomElement(User::where('role', 'customer')->pluck('id')->toArray()),
            'restaurant_id' => Restaurant::where('confirm', 'accept')->get()->random()->id,
            'status' => $this->faker->randomElement(['0', '1', '2', '3', '4']),
            'total_price' => $this->faker->randomFloat(2, 0, 1000000),
        ];
    }
}
