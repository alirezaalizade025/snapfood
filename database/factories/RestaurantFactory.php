<?php

namespace Database\Factories;

use App\Models\FoodType;
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
            'food_type_id' => FoodType::all()->random()->id,
            'phone' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'bank_account' => $this->faker->bankAccountNumber,
        ];
    }
}
