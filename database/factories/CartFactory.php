<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

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
            'status' => $this->faker->randomElement(['0', '1', '2', '3']),
            'total_price' => $this->faker->randomFloat(2, 0, 1000000),
        ];
    }
}
