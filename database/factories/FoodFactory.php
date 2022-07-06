<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\FoodParty;
use App\Models\Restaurant;
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
            'price' => $this->faker->randomFloat(2, 0, 100),
            'category_id' => Category::all()->random()->id,
            'discount' => $this->faker->randomNumber(2),
            'food_party_id' => FoodParty::all()->random()->id,
            'restaurant_id' => Restaurant::all()->random()->id,
        ];
    }
}
