<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\FoodType;
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
            'name' => $this->faker->name,
            'user_id' => User::where('role', 'restaurant')->get()->random()->id,
            'phone' => $this->faker->regexify('09\\d{9}$'),
            'food_type_id' => FoodType::all()->random()->id,
            'bank_account' => $this->faker->regexify('\\d{16}$'),
        ];
    }
}
