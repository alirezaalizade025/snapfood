<?php

namespace Database\Factories;

use App\Models\Cart;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => User::all()->where('role', 'customer')->random()->id,
            'cart_id' => Cart::all()->unique()->id,
            'score' => $this->faker->numberBetween(1, 5),
            'content' => $this->faker->sentence,
        ];
    }
}
