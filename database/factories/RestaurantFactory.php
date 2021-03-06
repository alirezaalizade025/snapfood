<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Restaurant>
 */
class RestaurantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->name,
            'user_id' => User::where('role', 'restaurant')->get()->random()->id,
            'phone' => $this->faker->regexify('09\\d{9}$'),
            'bank_account' => $this->faker->regexify('\\d{16}$'),
        ];
    }
}
