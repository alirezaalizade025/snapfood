<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Address;
use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $address = [
            'title' => $this->faker->randomElement(['job', 'home', 'office', 'other']),
            'address' => $this->faker->address,
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
        ];

        return $address;
    }
}
