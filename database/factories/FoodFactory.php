<?php

namespace Database\Factories;

use App\Models\FoodParty;
use App\Models\FoodType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Food>
 */
class FoodFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'price' => $this->faker->randomNumber(6),
            'image' => $this->faker->optional(0.5)->imageUrl(),
            'food_type_id' => FoodType::all()->random()->id,
            'discount' => $this->faker->randomNumber(2),
            'food_party_id' => FoodParty::all()->random()->id,
        ];
    }
}
