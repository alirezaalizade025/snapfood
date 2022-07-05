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
            'addressable_type' => $this->faker->randomElement([
                User::class ,
                Restaurant::class ,
            ]),
            'address' => $this->faker->address,
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
        ];

        if ($address['addressable_type'] == 'App\Models\User') {
            $address['addressable_id'] = User::where('role', 'customer')->get()->random()->id;
        }
        else {
            $id = Restaurant::get()->unique()->random()->id;
            if (Restaurant::find($id)->addressInfo) {
                $address['addressable_type'] = 'App\Models\User';
            }
            $address['addressable_id'] = $id;
        }
        return $address;
    }
}
